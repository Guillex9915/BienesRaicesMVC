<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'funciones.php';
require 'config/database.php';

use Model\ActiveRecord;

//conectarse a la DB
$db = conectarDB();
ActiveRecord::setDB($db);




?>