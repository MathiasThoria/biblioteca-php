<?php

session_start(); // iniciar sesión
//$_SESSION = [];
// Mockear un usuario administrador para pruebas
/*if (!isset($_SESSION['tipo'])) {
    $_SESSION['usuario'] = 'admin';
    $_SESSION['tipo'] = 'administrador';
}
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// index.php
require_once("controlador/ControladorFrente.php");

$controladorFrente = new ControladorFrente();

// Obtenemos parámetros de URL, por defecto a 'inicio'
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'general';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

// Delegamos al controlador frente
$controladorFrente->ejecutar($controlador, $accion);

?>