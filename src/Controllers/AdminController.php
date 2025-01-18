<?php
namespace Controllers;
use Lib\Pages;
use Services\categoryService;
use Services\userService;
use Services\productsService;
use Services\pedidosService;

class AdminController{
    private Pages $pages;
    private userService $userService;
    private categoryService $categoryService;
    private productsService $productsService;
    private pedidosService $pedidosService;

    public function __construct (){
        $this->pages=new Pages();
        $this->userService=new userService();
        $this->categoryService=new categoryService();
        $this->productsService=new productsService();
        $this->pedidosService=new pedidosService();
    }


    //Funcion para iniciar sesion
    public function index(){
        $gestion=[
            0=>[
                'title'=>'Gestion de categorias',
                'id'=>0
            ],
            1=>[
                'title'=>'Gestion de productos',
                'id'=>1
            ],
            2=>[
                'title'=>'Gestion de pedidos',
                'id'=>2
            ]];
            $categories= $this->categoryService->allCategories();

            $categories=array_map(function($category){
                return $category->toArray();
            },$categories);

            $products= $this->productsService->allProducts();
            $products=array_map(function($product){
                return $product->toArray();
            },$products);
            $pedidos= $this->pedidosService->allPedidos();
            $pedidos=array_map(function($pedido){
                return $pedido->toArray();
            },$pedidos);


        $this->pages->render('admin/index',['menu'=>$gestion,'categorias'=>$categories, 'products'=>$products,'pedidos'=>$pedidos]);


    }
}