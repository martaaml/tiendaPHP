<?php

namespace Controllers;

use Lib\Pages;
use Services\productsService;
use Services\categoryService;
use Models\Product;
use PDOException;

/**
 * Class CarritoController
 * @package Controllers
 * 
 */
class CarritoController
{
    private Pages $pages;
    private productsService $productsService;
    private categoryService $categoryService;

    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->pages = new Pages();
        $this->productsService = new productsService();
        $this->categoryService = new categoryService();
    }

    public function index()
    {
        $this->pages->render('carrito/carrito');
    }

    /**
     * Funcion que suma productos a carrito
     * 
     * 
     */
    public function sumar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['id']) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$_POST['id']])) {
                    $_SESSION['carrito'][$_POST['id']]++;
                } else {
                    $_SESSION['carrito'][$_POST['id']] = 1; //Si no existe le crea uno
                }
                $product = $this->productsService->findById($_POST['id']);
                //Si el stock es 0 o es menor a 0 no se puede sumar
                if ($product['stock'] == 0 || $product['stock'] - 1< 0) {
                    $_SESSION['carrito'][$_POST['id']]--;
                    $_SESSION['error'] = 'No hay stock';
                    header('Location: ' . BASE_URL);
                    return;
                }
                //Si el stock es menor que el que se suma, se resta 1 al stock
                if ($product['stock'] - $_SESSION['carrito'][$_POST['id']] < 0) {
                    $product['stock']--;
                    $this->productsService->update($product);
                }
                //Si el stock es mayor que el que se suma, se resta 1 al stock
                if ($product['stock'] - $_SESSION['carrito'][$_POST['id']] > 0) {
                    $product['stock']--;
                    $this->productsService->update($product);
                }

                $product['stock']=($product['stock']- $_SESSION['carrito'][$_POST['id']]);
                $this->productsService->update($product);
                header('Location: ' . BASE_URL);
                return;
            }
        }
    }

    /**
     * Funcion que quita productos a carrito
     * 
     */
    public function restar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['id']) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$_POST['id']])) {
                    $_SESSION['carrito'][$_POST['id']]--;
                    if ($_SESSION['carrito'][$_POST['id']] < 0) {
                        unset($_SESSION['carrito'][$_POST['id']]);
                    }
                    $product = $this->productsService->findById($_POST['id']);
                    $product['stock']=($product['stock']+ $_SESSION['carrito'][$_POST['id']]);
                    $this->productsService->update($product);
                    header('Location: ' . BASE_URL);
                    return;
                }
            }
        }
    }


    public function borrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['id']) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id]);
                try {
                    $this->productsService->delete($product);
                    $_SESSION['success'] = 'Producto eliminado';
                    header('Location: ' . BASE_URL . 'carrito');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('/carrito');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        } else {
            $_SESSION['error'] = 'Ha surgido un error';
        }

        return;
    }

    public function reactivar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['id']) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id, 'borrado' => false]);
                try {
                    $this->productsService->reactive($product);
                    $_SESSION['success'] = 'Producto reactivado';
                    header('Location: ' . BASE_URL . 'carrito');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('/carrito');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        }
    }

    public function verCarrito()
    {
        $this->pages->render('carrito/carrito');
        return;
    }

    public function updateStock(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $product= Product::fromArray(['id'=>$id]);
                try{
                    $this->productsService->update($product);
                    $_SESSION['success']='Stock actualizado';
                    header('Location: '.BASE_URL.'carrito');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('carrito/carrito   ');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }
    }

}
