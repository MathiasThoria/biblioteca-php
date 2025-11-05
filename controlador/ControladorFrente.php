<?php
class ControladorFrente {

    public function ejecutar($controlador, $accion) {
        //session_start();
        if (!isset($_SESSION['usuario']) && !($controlador == 'usuarios' && $accion == 'validar')) {
            // No está logueado y no está intentando loguear
            
            header("Location: index.php?controlador=usuarios&accion=validar");
            exit();
        }else{
            switch($controlador) {
                case 'libros':
                    require_once("ControladorLibros.php");
                    $ctrl = new ControladorLibros();
                    break;

                case 'usuarios':
                    require_once("ControladorUsuarios.php");
                    $ctrl = new ControladorUsuarios();
                    break;

                case 'prestamos':
                    require_once("ControladorPrestamos.php");
                    $ctrl = new ControladorPrestamos();
                    break;
                case 'ejemplares':
                    require_once("ControladorEjemplares.php");
                    $ctrl = new ControladorEjemplares();
                    break;
                case 'general':
                default:
                    include(__DIR__."/../vista/VistaMenu.php");
                    return;
                    break;
            }
            if (method_exists($ctrl, $accion)) {
                $ctrl->$accion($_GET, $_POST);
            } else {
                echo "Acción '$accion' no encontrada en el controlador '$controlador'.";
            }       
        }
    }
}
?>
