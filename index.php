<?php
ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);

define('BASE_URL', 'http://localhost/biblioteca-php-main/');
ini_set('session.save_path', '/tmp');
session_start(); 

require_once("controlador/ControladorFrente.php");

$controladorFrente = new ControladorFrente();

// Obtenemos parámetros de URL, por defecto a 'inicio'
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'general';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

// Delegamos al controlador frente
$controladorFrente->ejecutar($controlador, $accion);

?>