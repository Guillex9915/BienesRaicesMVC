<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{

    public static function crear(Router $router)
    {
        $vendedor = new Vendedor();
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            //Crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            //Validamos la información que hemos recibido
            $errores = $vendedor->validar();


            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor,


        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');
        //Validar que sea un ID valido
        $vendedor = Vendedor::find($id);
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los valores
            $args = $_POST['vendedor'];
            $vendedor->sincronizar($args);

            //Validación
            $errores = $vendedor->validar();
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('/vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor,
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }

            }
        }
    }
}