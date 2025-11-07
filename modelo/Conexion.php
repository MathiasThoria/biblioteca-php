<?php

//SINGLETON
// Habitulamente existirian dos metodos: getConexion y getInstancia. 
// Se decide dejar solo getConexion para simplificar el acceso a la conexion.

class Conexion {
    private static $conexion = null;

    private function __construct() {
        // Constructor privado: evita instanciar directamente
    }

    public static function getConexion() {
        // Si no existe, se crea una sola vez
        if (self::$conexion == null) {
            self::$conexion = mysqli_connect("localhost", "root", "root", "biblioteca");
            if (!self::$conexion) {
                die("Error al conectar: " . mysqli_connect_error());
            }
            mysqli_set_charset(self::$conexion, "utf8");
        }
        // Siempre devuelve la misma conexión
        return self::$conexion;
    }
}
?>
