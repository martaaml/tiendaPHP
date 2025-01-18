<?php

    namespace Routes;

use Controllers\AdminController;
use Lib\Router;
    use Controllers\AuthController;
    use Controllers\ErrorController;
use Controllers\ProductoController;
use Controllers\CategoriasController;

    class Routes{
        public static function index() {
        Router::add('GET','/',function(){
            (new ProductoController())->index();
        });
        //Router del registro
        Router::add('GET','/register',function(){
            (new AuthController())->register();
        });
        
        Router::add('POST','/register',function(){
            (new AuthController())->register();
        });
        
        //Router del login
        Router::add('GET','/login',function(){
            (new AuthController())->login();
        });
        Router::add('POST','/login',function(){
            (new AuthController())->login();
        });
        Router::add('GET','/logout',function(){
            (new AuthController())->logout();
        });
        if(isset($_SESSION['admin'])){
            Router::add('GET','/admin',function(){
                (new AdminController())->index();
            });
            Router ::add ('POST','/categorias',function(){
                (new CategoriasController())->store();
            });
        Router::add('POST','/productos',function(){
            (new ProductoController())->store();
        });

        }
       
        Router::add('GET','/categorias',function(){
            (new CategoriasController())->index();
        });

    
        
            Router::dispatch();
        }
 }