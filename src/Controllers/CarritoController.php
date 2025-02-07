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
 */
class CarritoController
{
    private Pages $pages;
    private productsService $productsService;
    private categoryService $categoryService;

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
     * Función que suma productos al carrito
     */
    public function sumar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$_POST['id']])) {
                    $_SESSION['carrito'][$_POST['id']]++;
                } else {
                    $_SESSION['carrito'][$_POST['id']] = 1; // Si no existe, se inicializa en 1
                }

                $product = $this->productsService->findById($_POST['id']);

                // Si no hay stock suficiente, no se permite la compra
                if ($product->getStock() == 0 || $product->getStock() - 1 < 0) {
                    $_SESSION['carrito'][$_POST['id']]--;
                    $_SESSION['error'] = 'No hay stock disponible';
                    header('Location: ' . BASE_URL);
                    return;
                }

                // Se reduce el stock en 1 si es válido
                if ($product->getStock() - $_SESSION['carrito'][$_POST['id']] >= 0) {
                    $product->setStock($product->getStock() - 1);
                    $this->productsService->update($product);
                }

                header('Location: ' . BASE_URL);
                return;
            }
        }
    }

    /**
     * Función que resta productos del carrito
     */
    public function restar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$_POST['id']]) && $_SESSION['carrito'][$_POST['id']] > 0) {
                    $_SESSION['carrito'][$_POST['id']]--;

                    $product = $this->productsService->findById($_POST['id']);
                    $product->setStock($product->getStock() + 1); // Incrementa el stock
                    $this->productsService->update($product);

                    if ($_SESSION['carrito'][$_POST['id']] == 0) {
                        unset($_SESSION['carrito'][$_POST['id']]);
                    }

                    header('Location: ' . BASE_URL);
                    return;
                }
            }
        }
    }

    /**
     * Función que borra productos del carrito
     */
    public function borrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id]);
                try {
                    $this->productsService->delete($product);
                    $_SESSION['success'] = 'Producto eliminado';
                    header('Location: ' . BASE_URL . 'carrito');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('/carrito/carrito');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        } else {
            $_SESSION['error'] = 'Ha surgido un error';
        }
    }

    /**
     * Función que reactiva productos eliminados
     */
    public function reactivar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id, 'borrado' => false]);
                try {
                    $this->productsService->reactive($product);
                    $_SESSION['success'] = 'Producto reactivado';
                    header('Location: ' . BASE_URL . 'carrito');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('/carrito/carrito');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        }
    }

    /**
     * Muestra la vista del carrito
     */
    public function verCarrito()
    {
        $this->pages->render('carrito/carrito');
    }

    /**
     * Actualiza el stock de un producto
     */
    public function updateStock()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $product = Product::fromArray(['id' => $id]);
                try {
                    $this->productsService->update($product);
                    $_SESSION['success'] = 'Stock actualizado';
                    header('Location: ' . BASE_URL . 'carrito');
                    return;
                } catch (PDOException $e) {
                    $_SESSION['error'] = 'Ha surgido un error';
                    $this->pages->render('carrito/carrito');
                    return;
                }
            } else {
                $_SESSION['error'] = 'Ha surgido un error';
            }
        }
    }
}
    