<?php

namespace Model;


class Propiedad extends ActiveRecord
{

    protected static $tabla = 'propiedades';
    protected static $columnasDB = [
        'id', 'titulo', 'imagen', 'precio', 'descripcion', 'habitaciones', 'wc', 'estacionamiento',
        'creado', 'vendedorId'
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $vendedorId;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
            //  exit;
        }
        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
            //exit;
        }
        if (strlen($this->descripcion) < 25) {
            self::$errores[] = "La descripción es obligatoria y debe tener mínimo 25 caracteres";
            // exit;
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Debes especificar las habitaciones que tiene la propiedad";
            //exit;
        }
        if (!$this->wc) {
            self::$errores[] = "Debes especificar los baños que tiene la propiedad";
            // exit;
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes especificar los estacionamientos que tiene la propiedad";
            //   exit;
        }
        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
            // exit;
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }


        return self::$errores;
    }


}
