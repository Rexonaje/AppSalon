<?php
namespace Controllers;

use MVC\Router;

class CitaController{
    public static function index(Router $router){
        if (session_status() == PHP_SESSION_NONE) {
             session_start();
        }
        //obtengo de $_session los datos del user
        $_SESSION;
        $router->render('cita/index',[
            'nombre'=>$_SESSION['nombre']
        ]);
    }

}