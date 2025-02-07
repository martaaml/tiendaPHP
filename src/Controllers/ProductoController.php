<?php

namespace Controllers;

use Lib\Pages;
use Services\productsService;
use Models\Product;
use PDOException;

/**
 * Clase de controlador para manejar productos
 * @package Controllers
 */

class ProductoController
{
    private Pages $pages;
    private productsService $productsService;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productsService = new productsService();
    }


    /**
     * Función para mostrar los productos
     * @return void
     * 
     */

    public function index()
    {
        $products = $this->productsService->findActive();
        $products = array_map(fn($product) => $product->toArray(), $products);
        $this->pages->render('productos/destacados', ['products' => $products]);
    }

    /**
     * Función para almacenar un producto   
     * @return void
     * 
     */
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

    /**
     * Función para borrar un producto  
     * @param int $id
     * @return void
     * 
     */
    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id']; 
            $productService = new \Services\productsService();
            $product = $productService->findById($id);

    
            if ($product) {
                $result = $productService->delete($product);
                $_SESSION['success'] = 'Producto eliminado';
                header('Location: ' . BASE_URL);
                return;
        } else {
            echo "ID del producto no proporcionado.";
        }
    }

}
    
    /**
     * Función para reactivar un producto
     * @return void
     * 
     */
    public function reactive()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // Obtener el ID desde el formulario o solicitud POST
            $productService = new \Services\productsService();
            $product = $productService->findById($id);
    
            if ($product) {
                $result = $productService->reactive($product);
                $_SESSION['success'] = 'Producto reactivado';
                header('Location: ' . BASE_URL);
                return;
            }
    }
}  


/**
 * Función para actualizar un producto
 * @return void
 * 
 */
public function update(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $producto = $this->productsService->findById($id);

        if (!$producto) {
            $_SESSION['error'] = 'El producto no existe';
            header('Location: ' . BASE_URL . 'carrito');
            return;
        }

        // Renderiza la vista de edición con el producto seleccionado
        $this->pages->render('carrito/editar', ['producto' => $producto]);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'], $_POST['cantidad']) && is_numeric($_POST['cantidad'])) {
            $id = $_POST['id'];
            $cantidad = intval($_POST['cantidad']);

            if ($cantidad <= 0) {
                $_SESSION['error'] = 'La cantidad debe ser mayor a 0';
                header("Location: " . BASE_URL . "carrito/editar?id=$id");
                return;
            }

            // Actualiza la cantidad en la sesión del carrito
            $_SESSION['carrito'][$id] = $cantidad;

            $_SESSION['success'] = 'Producto actualizado correctamente';
            header('Location: ' . BASE_URL . 'carrito');
            return;
        } else {
            $_SESSION['error'] = 'Error en la actualización';
        }
    }
}
}