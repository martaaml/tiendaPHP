<?php
namespace Controllers;
use Lib\Pages;
use Services\pedidosService;
use Models\Pedido;
use PDOException;

class PedidoController{
    private Pages $pages;
    private pedidosService $pedidosService;
    public function __construct (){
        $this->pages=new Pages();
        $this->pedidosService=new pedidosService();
    }


    public function index() {
        $pedidos = $this->pedidosService->findAll(); // Mantiene los pedidos como objetos
        $this->pages->render('pedidos/mispedidos', ['pedidos' => $pedidos]);
    }
    

    public function store(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['nombre'] && $_POST['email'] && $_POST['telefono'] && $_POST['provincia'] && $_POST['localidad'] && $_POST['direccion'] && $_POST['coste'] && $_POST['estado'] && $_POST['fecha'] && $_POST['hora'] && $_POST['borrado']){
                $nombre=$_POST['nombre'];
                $email=$_POST['email'];
                $telefono=$_POST['telefono'];
                $provincia=$_POST['provincia'];
                $localidad=$_POST['localidad'];
                $direccion=$_POST['direccion'];
                $coste=$_POST['coste'];
                $estado=$_POST['estado'];
                $fecha=$_POST['fecha'];
                $hora=$_POST['hora'];
                $borrado=$_POST['borrado'];
                $pedido= Pedido::fromArray(['nombre'=>$nombre,'email'=>$email,'telefono'=>$telefono,'provincia'=>$provincia,'localidad'=>$localidad,'direccion'=>$direccion,'coste'=>$coste,'estado'=>$estado,'fecha'=>$fecha,'hora'=>$hora,'borrado'=>$borrado]);
                try{
                    $this->pedidosService->store($pedido);
                    $_SESSION['success']='Pedido creado';
                    header('Location: '.BASE_URL.'pedidos/mispedidos');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('pedidos/mispedidos');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{
            $_SESSION['error']='Ha surgido un error';
        }
        $this->pages->render('pedidos/mispedidos');
        return;
    }
    public function delete(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $pedido= Pedido::fromArray(['id'=>$id]);
                try{
                    $this->pedidosService->delete($pedido);
                    $_SESSION['success']='Pedido eliminado';
                    header('Location: '.BASE_URL.'pedidos/mispedidos');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('pedidos/mispedidos');
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
    public function reactive(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['id']){
                $id=$_POST['id'];
                $pedido= Pedido::fromArray(['id'=>$id,'borrado'=>false]);
                try{
                    $_SESSION['success']='Pedido reactivado';
                    header('Location: '.BASE_URL.'pedidos/mispedidos');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('pedidos/mispedidos');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }
    }

}