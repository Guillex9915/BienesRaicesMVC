<?php
namespace Model;

class ActiveRecord {

    //BD

    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';


    //Errores
    protected static $errores = [];


    
    

    //Subida de archivos
    public function setImagen($imagen)
    {
        //Elimina la imagen previa
        if (isset($this->id)) {
            //Comprobamos si existe la imagen
            $this->borrarImagen();
        }

        //Asigna la imagen previa
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Elimina la imagen
    public function borrarImagen(){
         //Comprobamos si existe la imagen
         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
         if ($existeArchivo) {
             unlink(CARPETA_IMAGENES . $this->imagen);
         }
    }

    public function guardar()
    {
        
        if (!is_null($this->id)) {
            //Actualizando un archivo
            $this->actualizar();
        } else {
            //Creando un nuevo registro
            $this->crear();
        }
    }

    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        $resultado = self::$db->query($query);
        if ($resultado) {
            header('location: /admin?resultado=2');
        }
    }

    
    public function crear()
    {
        $atributos = $this->sanitizarAtributos();

        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ')";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // echo "Insertado correctamente en la DB";
            header('location: /admin?resultado=1');
        }
    }

    // Eliminar los registros
    public function eliminar(){
            //Eliminar la propiedad
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);
            $resultado = self::$db->query($query);
            
            if ($resultado) {
            $this->borrarImagen();
                header("location: /admin?resultado=3");
            }

    }


    //Sanitizar la entrada
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();

        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //Conexión DB

    public static function setDB($database)
    {
        self::$db = $database;
    }

    //Validación de errores

    public static function getErrores()
    {
        
        return static::$errores;
    }

    

    //Lista toda las propiedades
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Busca una propiedad por su id

    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla .  " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        

        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);
        

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        //Liberar la memoria
        $resultado->free();

        //retornar el resultado
        return $array;
    }

    //Crear objeto para convertir los arreglos que devuelva la DB a objetos, debido a ActiveRecord
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            //Property Exist verifica que una propiedad exista y que mantenga los mismos valores
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public function validar()
    {
        
        static::$errores = [];
        return static::$errores;
    }

    //Obtiene limites de registros a mostrar en el index.php
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }


}

?>