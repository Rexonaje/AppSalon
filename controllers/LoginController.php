<?php 
namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router ){
        $alertas=[];
        
         if($_SERVER['REQUEST_METHOD']==='POST'){
                
            $auth=new Usuario($_POST);
           $alertas= $auth->validarLogin();
           if(empty($alertas)){
                $usuario=Usuario::where('email',$auth->email);
                if($usuario){ 
                    //verify passwprd
                     if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //iniciar sesion
                        if(!isset($_SESSION)){session_start();}
                        $_SESSION['id']=$usuario->id;
                        $_SESSION['nombre']=$usuario->nombre. " " . $usuario->apellido;
                        $_SESSION['email']=$usuario->email;
                        $_SESSION['login']=true;
                        //redirecciono
                        if($usuario->admin ==="1"){
                            $_SESSION['admin']=$usuario->admin ??null;
                            header('location: /admin'); 
                        }else{
                            //debuguear($_SESSION);
                            header('location: /cita'); 
                        }
                     }         

                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
           }
         }
         $alertas=Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas'=>$alertas,
             
        ]);
    }
    public static function logout(Router $router){
        echo "desde logout";
        $router->render('auth/logout',[]);
    }
    public static function olvide(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth=new Usuario($_POST);
            $alertas= $auth->validarEmail();
            if(!$alertas){
               $usuario=Usuario::where('email',$auth->email);
                  //existe     //confirmado
               if($usuario && $usuario->confirmado ==="1"){
                //generar token de una vez
                    $usuario->crearToken();
                    $usuario->guardar();
                //TODO ernviar mail
                $email=new Email($usuario->email,$usuario->nombre,$usuario->token);
                $email->enviarInstrucciones();
                //alerta exito
                    Usuario::setAlerta('exito','Revisa tu email'); 
               }else{
                    Usuario::setAlerta('error','Usuario no existe o no confirmado');
                }
            }
        }
        $alertas=Usuario::getAlertas();

       $router->render('auth/olvide-password',[
            'alertas'=>$alertas
       ]);
        
    }
    public static function recuperar(Router $router ){
        $alertas=[];
        $token=s($_GET['token']);
        $error=false;
        //buscar user x token
        $usuario=Usuario::where('token',$token);
       
        if(empty($usuario)){
            Usuario::setAlerta('error','Token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            // leer password y guardar
            $password=new Usuario($_POST);
            $alertas= $password->validarPassword();

            if(empty($alertas)){
                $usuario->password=null;
                $usuario->password=$password->password;
                $usuario->hashPassword();
                $usuario->token=null;
               
                if($resultado=$usuario->guardar()){
                    header('location: /');
                }
            }
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=>$error
        ]); 
        
    }
    public static function crear( Router $router){
        $usuario = new Usuario();
         
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            
         
           $usuario->sincronizar($_POST);
           $alertas=$usuario->validarNuevo();
          //si no hay errores
           if(empty($alertas)){
            //verifico user 
                $resultado= $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas=Usuario::getAlertas();
                }else{
                    //hash 
                    $usuario->hashPassword();
                    
                    //generar user unico
                    $usuario->crearToken();
                    //enviar el mail de confirmacion
                    $Email= New Email($usuario->email,$usuario->nombre,$usuario->token);
                    $Email->enviarConfirmacion();
                    //crear user
                    $resultado=$usuario->guardar();
                        if($resultado){
                            header('location: /mensaje');
                        }

                }
           }
         
        }
        $router->render('auth/crear-cuenta',[
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
        
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[]);
    }
    public static function confirmar(Router $router){
        $alertas=[];
        $token=s($_GET['token']);
        $usuario= Usuario::where('token',$token);
        
        if(empty($usuario)){
          Usuario::setAlerta('error','Usuario inexistente o token invalido');
        }
         
        else{
            
            //si no hay errores con el token, se cambian los siguientes valores en la db
            $usuario->confirmado="1";
            $usuario->token="done";
            $usuario->guardar();
            $usuario->setAlerta('exito','Cuenta confirmada correctamente');
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas'=>$alertas
        ]);
    }
}