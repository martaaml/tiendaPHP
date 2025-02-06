<?php

namespace Controllers;

use Lib\Pages;
use Services\productsService;
use Models\Product;
use PDOException;

class ProductoController
{
    private Pages $pages;
    private productsService $productsService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productsService = new productsService();
    }

    public function index()
    {
        $products = $this->productsService->findActive();
        $products = array_map(fn($product) => $product->toArray(), $products);
        $this->pages->render('productos/destacados', ['products' => $products]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['nombre']) && !empty($_POST['descripcion']) && isset($_POST['precio']) && is_numeric($_POST['precio']) && !empty($_POST['stock']) && !empty($_POST['oferta']) && !empty($_POST['fecha']) && !empty($_POST['imagen'])) {
                
                $categoria_id = $_POST['categoria_id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = floatval($_POST['precio']);
                $stock = $_POST['stock'];
                $oferta = $_POST['oferta'];
                $fecha = $_POST['fecha'];
                $imagen = $_POST['imagen'];

                $productData = [
                    'categoria_id' => $categoria_id,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'fecha' => $fecha,
                    'imagen' => $imagen
                ];

                if (!empty($_POST['id'])) {
                    $productData['id'] = $_POST['id'];
                    $product = Product::fromArray($productData);
                    try {
                        $this->productsService->update($product);
                        $_SESSION['success'] = 'Producto editado';
                        header('Location: ' . BASE_URL);
                        exit;
                    } catch (PDOException $e) {
                        $_SESSION['error'] = 'Ha surgido un error';
                    }
                } else {
                    $product = Product::fromArray($productData);
                    try {
                        $this->productsService->store($product);
                        $_SESSION['success'] = 'Producto creado';
                        header('Location: ' . BASE_URL);
                        exit;
                    } catch (PDOException $e) {
                        $_SESSION['error'] = 'Ha surgido un error';
                    }
                }
            } else {
                $_SESSION['error'] = 'Faltan datos';
            }
        } else {
            $_SESSION['error'] = 'Método inválido';
        }
        $this->pages->render('productos/principales');
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id']; 
            $productService = new \Services\productsService();
            $product = $productService->findById($id);
    
            if ($product) {
                $result = $productService->delete($product);
                if ($result === null) {
                    echo "Producto eliminado correctamente.";
                } else {
                    echo "Error al eliminar el producto: " . $result;
                }
            } else {
                echo "Producto no encontrado.";
            }
        } else {
            echo "ID del producto no proporcionado.";
        }
    }
    
    public function reactive()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID desde el formulario o solicitud POST
            $productService = new \Services\productsService();
            $product = $productService->findById($id);
    
            if ($product) {
                $result = $productService->reactive($product);
                if ($result === null) {
                    echo "Producto reactivado correctamente.";
                } else {
                    echo "Error al reactivar el producto: " . $result;
                }
            } else {
                echo "Producto no encontrado.";
            }
        } else {
            echo "ID del producto no proporcionado.";
        }
    }

    public function update(){
        
    }
    
}
