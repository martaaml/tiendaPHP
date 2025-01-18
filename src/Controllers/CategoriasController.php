<?php
namespace Controllers;
use Lib\Pages;
use Services\categoryService;
use Models\Category;
use PDOException;


class CategoriasController{
    private Pages $pages;
    private categoryService $categoryService;
    public function __construct (){
        $this->pages=new Pages();
        $this->categoryService=new categoryService();
    }


    //Funcion para iniciar sesion
    public function index(){
        $categorias= $this->categoryService->allCategories();
        $categorias=array_map(function($categoria){
            return $categoria->toArray();
        },$categorias);

        $this->pages->render('categorias/principales',['categorias'=>$categorias]);
    }

    public function store(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['nombre']){
                $nombre=$_POST['nombre'];
                $categoria= Category::fromArray(['nombre'=>$nombre]);
                try{
                    $this->categoryService->store($categoria);
                    $_SESSION['success']='Categoria creada';
                    header('Location: '.BASE_URL.'categorias');
                    return;
                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('categorias/principales');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{
            $_SESSION['error']='Ha surgido un error';
        }
        $this->pages->render('categorias/principales');
        return;

    }   
}
