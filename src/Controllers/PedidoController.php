<?php
namespace Controllers;
use Lib\Pages;
use Services\pedidosService;

class PedidoController{
    private Pages $pages;
    private pedidosService $pedidosService;
    public function __construct (){
        $this->pages=new Pages();
        $this->pedidosService=new pedidosService();
    }


    //Funcion para iniciar sesion
    public function index(){
        $pedidos= $this->pedidosService->allPedidos();
        $pedidos=array_map(function($pedido){
            return $pedido->toArray();
        },$pedidos);

        $this->pages->render('pedidos/destacados',['pedidos'=>$pedidos]);
    }
}