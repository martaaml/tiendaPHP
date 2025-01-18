<?php
namespace Controllers;
use Lib\Pages;
use Models\User;
use Services\userService;
use PDOException;


  class AuthController{
    private Pages $pages;
    private userService $userService;
    public function __construct (){
        $this->pages=new Pages();
        $this->userService=new userService();
    }


    //Funcion para iniciar sesion
    public function login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
        
            if($_POST['email'] && $_POST['password']){
                $email=$_POST['email'];
                $password=$_POST['password'];
                $user=$this->userService->getIdentity($email);
                if($user){
                    if(password_verify($password,$user['password'])){
                        $_SESSION['user']=$user;
                        $_SESSION['success']='Sesión iniciada';
                        if($user['rol']==='admin'){
                            $_SESSION['admin']=true;
                        }

                        header('Location: '.BASE_URL);
                        return;
                    }else{
                        $this->pages->render('Auth/loginForm');
                        return;
                    }
                }else{
                    $this->pages->render('Auth/loginForm');
                    return;
                }
            }
        }else{
               $this->pages->render('Auth/loginForm');
        }
    }

    //Funcion para cerrar sesion
    public function logout(){
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
        }
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
            header('Location: '.BASE_URL);
        }
    }
    
    public function register(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if($_POST['data']){

            $data=$_POST['data'];
            $user= User::fromArray($data);
    
                //Validar los datos, el modelo es quien lo valida

                $newPassword=password_hash($user->getPassword(),PASSWORD_BCRYPT,['cost'=>4]);
                $user->setPassword($newPassword);
                try{
                    $this->userService->register($user);
                    $_SESSION['success']='Registro exitoso';
                    header('Location: '.BASE_URL.'login');
                    
                    return;

                }catch( PDOException $e){
                    $_SESSION['error']='Ha surgido un error';
                    $this->pages->render('Auth/registerForm');
                    return;
                }
            }else{
                $_SESSION['error']='Ha surgido un error';
            }
        }else{

            $this->pages->render('Auth/registerForm');
        }
    }
  }
  ?>