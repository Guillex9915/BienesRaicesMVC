<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;



class PaginasController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => true,

        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function propiedades(Router $router)
    {

        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad,
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Buscamos los errores en los datos
            $errores = [];
            $campos = $_POST['contacto'];
            $fechaUser = $campos['fecha'];
            $fechaActual = date('Y-m-d');
            $horaUser = explode(':', $campos['hora']);

            //Buscando los errores
            if (!$campos['nombre']) {
                $errores[] = "El nombre es obligatorio";
            }
            if (!$campos['mensaje']) {
                $errores[] = "El mensaje es obligatorio";
            }
            if (!$campos['tipo']) {
                $errores[] = "Es obligatorio saber si vende o compra";
            }
            if (!$campos['precio']) {
                $errores[] = "Es obligatorio saber su presupuesto";
            }

            if($campos['contacto'] === 'telefono'){
                if (intval($horaUser[0]) >= 8 and intval($horaUser[0]) <= 17) {
                    if (intval($horaUser[0]) === 17) {
                        if (intval($horaUser[1]) === 00) {
                        } else {
                            $errores[] = "Horario válido 08:00 - 17:00";
                        }
                    }
                } else {
                    $errores[] = "El horario debe ser válido entre 08:00 - 17:00";
                }
                if ($fechaActual >= $fechaUser) {
                    $errores[] = "Debe ser una fecha futura";
                }
                if(!$campos['telefono']){
                    $errores[] = "El teléfono es obligatorio";

                }

            }
            if ($campos['contacto'] === 'email') {
                if(!$campos['email']){
                    $errores[] = "El correo es obligatorio";
                }

            }
            
            if (empty($errores)) {

                $respuestas = $_POST['contacto'];
                //Proeceso para enviar correos con PHPMailer y Mailtrap
                //Primero creamos una instancia de PHPMailer
                $mail = new PHPMailer();
                //Configurando el protocolo de envio de emails SMTP
                $mail->IsSMTP();
                //Configurando el host para envio de emails SMTP
                $mail->Host = 'smtp.mailtrap.io';
                //Configurando para autenticar para envio de emails SMTP
                $mail->SMTPAuth = true;
                //Generando las credenciales
                $mail->Username = '7a56cb8442cee2';
                $mail->Password = '438063a121ecea';
                //Usando el protocolo de seguridad para enviar mails
                $mail->SMTPSecure = 'tls';
                //Configurando el cifrado de seguridad para enviar mails
                $mail->Port = 2525;

                //Configurar el encabezado del mail
                $mail->setFrom('admin@bienesraices.com');
                $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
                $mail->Subject = 'Bienes Raíces Proyecto';
                

                //Habilitar HTML
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                //Definir el contenido

                //Enviar mensajes de forma condicional
                if($respuestas['contacto'] === 'telefono'){
                    $contenido = '<html>';
                    $contenido .= '<h4>¡Gracias por hacer uso de la plataforma de Bíenes Raíces ' . $respuestas['nombre'] . '!</h4>';
                    $contenido .= '<h5>Nos estaremos poniendo en contacto contigo vía llamada en la fecha: ' .  $respuestas['fecha'] . ' 
                     hora: ' . $respuestas['hora'] . '</h5>';
                    $contenido .= '<p>Los datos proporcionados son los siguientes: </p>';
                    $contenido .= '<p>Nombre: '. $respuestas['nombre'] .' </p>';
                    $contenido .= '<p>Teléfono: '. $respuestas['telefono'] .' </p>';
                    $contenido .= '<p>Presupuesto: $'. $respuestas['precio'] .' </p>';
                    $contenido .= '<p>Bíenes Raíces Todos los derechos Reservados ' . date('Y') . ' &copy;</p>';
                    $contenido .= '</html>';

                }else {
                    //Es un email
                    $contenido = '<html>';
                    $contenido .= '<h4>¡Gracias por hacer uso de la plataforma de Bíenes Raíces ' . $respuestas['nombre'] . '!</h4>';
                    $contenido .= '<h5>Te estaremos enviando un correo electrónico lo más pronto posible </h5>';
                    $contenido .= '<p>Los datos proporcionados son los siguientes: </p>';
                    $contenido .= '<p>Nombre: '. $respuestas['nombre'] .' </p>';
                    $contenido .= '<p>Correo: '. $respuestas['email'] .' </p>';
                    $contenido .= '<p>Presupuesto: $'. $respuestas['precio'] .' </p>';
                    $contenido .= '<p>Bíenes Raíces Todos los derechos Reservados ' . date('Y') . ' &copy;</p>';
                    $contenido .= '</html>';

                }
               

                $mail->Body = $contenido;
                $mail->AltBody = 'texto alternativo';
                if($respuestas['contacto'] === 'email'){
                    $mail->addAddress($respuestas['email'], $respuestas['nombre']);
                    mail($respuestas['email'], 'BienesRaices', $contenido, 'BienesRaices');
                }
                

                //Enviar el contenido
                if ($mail->send()) {
                    $mensaje =  'Mensaje enviado correctamente';
                    $campos = [];
                    $respuestas = [];
                } else {
                    $mensaje = 'Error al enviar mensaje...';
                }
            }
        }
        $router->render('paginas/contacto', [
            'errores' => $errores,
            'campos' => $campos,
            'mensaje' => $mensaje,
        ]);
    }
}
