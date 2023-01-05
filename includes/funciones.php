<?php
define('TEMPLATE_URL', __DIR__ . '/template');
define('FUNCIONES_URL',  __DIR__ .  'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATE_URL . "/${nombre}.php";
}

function estaAutenticado(): bool
{
    session_start();
    $auth = $_SESSION['login'];

    if ($auth) {
        return true;
    }

    return false;
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapa / Sanitizar HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

//Validar que  el tipoo de contenido no se altere en form de vendedores

function validarTipoContenido($tipo)
{
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
    //in_array: Recorre todo el array y devuelve el que coincide, primer valor a encontrar, 
    //segundo valor el array de los valores a comparar
}

//Muestra mensaje personalizado
function mostrarNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    //Validando que pase el ID por el metodo GET sea un entero
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: ${url}");
    }

    return $id;
}
