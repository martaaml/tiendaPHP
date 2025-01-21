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
        $products = array_map(function ($product) {
            return $product->toArray();
        }, $products);

        $this->pages->render('productos/destacados', ['products' => $products]);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['nombre'] && $_POST['descripcion'] && floatval($_POST['precio'])  && $_POST['stock'] && $_POST['oferta'] && $_POST['fecha'] && $_POST['imagen']&& $_POST['id']) {
                $categoria_id = $_POST['categoria_id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = floatval($_POST['precio']);
                $stock = $_POST['stock'];
                $oferta = $_POST['oferta'];
                $fecha = $_POST['fecha'];
                $imagen = $_POST['imagen'];
                $id = $_POST['id'];
                $product = Product::fromArray(['categoria_id' => $categoria_id, 'nombre' => $nombre, 'descripcion' => $descripcion, 'precio' => $precio, 'stock' => $stock, 'oferta' => $oferta, 'fecha' => $fecha, 'imagen' => $imagen, 'id' => $id]);
                try {
                    $this->productsService->update($product);
                    $_SESSION['success'] = 'Producto editado';
                    header('Location: ' . BASE_URL );
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('productos/principales');
                    return;
                }
            } else if ($_POST['nombre'] && $_POST['descripcion'] && floatval($_POST['precio'])  && $_POST['stock'] && $_POST['oferta'] && $_POST['fecha'] && $_POST['imagen']) {
                $categoria_id = $_POST['categoria_id'];
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = floatval($_POST['precio']);
                $stock = $_POST['stock'];
                $oferta = $_POST['oferta'];
                $fecha = $_POST['fecha'];
                $imagen = $_POST['imagen'];
                $product = Product::fromArray(['categoria_id' => $categoria_id, 'nombre' => $nombre, 'descripcion' => $descripcion, 'precio' => $precio, 'stock' => $stock, 'oferta' => $oferta, 'fecha' => $fecha, 'imagen' => $imagen]);
                try {
                    $this->productsService->store($product);
                    $_SESSION['success'] = 'Producto creado';
                    header('Location: ' . BASE_URL);
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('productos/principales');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        } else {
            $_SESSION['error'] = 'Ha surgido un error';
        }
        $this->pages->render('productos/principales');
        return;
    }


    public function delete()
    {
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $categoria= Product::fromArray(['id'=>$id]);
                try{
                    $this->productsService->delete($categoria);
                    $_SESSION['success']='Categoria eliminada';
                    header('Location: '.BASE_URL.'productos');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('productos/destacados');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{
            $_SESSION['error']='Ha surgido un error';
        }
        
        return;
    }


    public function reactive()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['id']) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id, 'borrado' => false]);
                try {
                    $this->productsService->reactive($product);
                    $_SESSION['success'] = 'Producto reactivado';
                    header('Location: ' . BASE_URL . 'categorias');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('productos/principales');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        }
    }
}
