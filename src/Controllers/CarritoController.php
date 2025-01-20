<?php

namespace Controllers;

use Lib\Pages;
use Services\productsService;

class CarritoController
{
    private Pages $pages;
    private productsService $productsService;
    public function __construct()
    {
        $this->pages = new Pages();
        $this->productsService = new productsService();
    }

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
             
                if ($product['stock'] == 0 || $product['stock'] - 1< 0) {
                    $_SESSION['carrito'][$_POST['id']]--;
                    $_SESSION['error'] = 'No hay stock';
                    header('Location: ' . BASE_URL);
                    return;
                }

                $product['stock']=($product['stock']- $_SESSION['carrito'][$_POST['id']]);
                $this->productsService->update($product);
                header('Location: ' . BASE_URL);
                return;
            }
        }
    }

    public function remover()
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
}
