<?php
namespace Controllers;
 use Lib\Pages;
use Services\productsService;

class ProductoController{
    private Pages $pages;
    private productsService $productsService;
    public function __construct( )
    {
        $this->pages= new Pages();
        $this->productsService= new productsService();
    }

    public function index(){
        $products= $this->productsService->allProducts();
        $products=array_map(function($product){
            return $product->toArray();
        },$products);

        $this->pages->render('productos/destacados',['products'=>$products]);
    }
}