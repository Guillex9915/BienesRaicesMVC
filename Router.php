<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn){
        $this->rutasGET[$url] = $fn;
    }
    public function post($url, $fn){
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas(){
        session_start();
        $auth = $_SESSION['login'] ?? null;

        //Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar' 
                            , '/vendedores/crear', '/vendedores/actualizar'];
        $urlActual = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null; //Valida que el path sea valido sino es null
            
        } else if ($metodo === 'POST'){
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //Proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /'); 
        }

        if($fn){
            //Si hay una URL asociada
            /*
            call_user_func(): es una funcion que
            nos permite llamar una funcion cuando no sabemos
            como se llama la funcion
            */
            call_user_func($fn, $this);

        }else{
            echo("Página no encontrada...");
        }

    }

    public function render($view, $datos= []){

        foreach($datos as $key=>$value){
            $$key = $value; //Doble $$ significa variable de variable
        }
        ob_start();
        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}