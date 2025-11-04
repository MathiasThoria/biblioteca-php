<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once("..controlador/ControladorLibros.php");


$controlador = new ControladorLibros();

// Obtener acción desde URL, por defecto 'listar'
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';

// Dependiendo de la acción, ejecutar el método correspondiente
switch ($accion) {
    case 'listar':
        $controlador->listar();
        break;

    case 'ver':
        if (isset($_GET['id'])) {
            $controlador->ver($_GET['id']);
        } else {
            echo "ID de libro no especificado.";
        }
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos del formulario
            $controlador->crear($_POST);
        } else {
            // Mostrar formulario de alta
            include("vista/formulario_libro.php");
        }
        break;

    case 'editar':
        if (!isset($_GET['id'])) {
            echo "ID de libro no especificado.";
            break;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos del formulario para editar
            $controlador->editar($_GET['id'], $_POST);
        } else {
            // Mostrar formulario de edición
            include("vista/formulario_libro.php");
        }
        break;

    case 'eliminar':
        if (isset($_GET['id'])) {
            $controlador->eliminar($_GET['id']);
        } else {
            echo "ID de libro no especificado.";
        }
        break;

    default:
        echo "Acción no reconocida.";
}
?>

