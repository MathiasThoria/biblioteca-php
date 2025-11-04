<?php
class ControladorFrente {

    public function ejecutar($controlador, $accion) {
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

            case 'general':
            default:
                include(__DIR__."/../vista/VistaMenu.php");
                return;
                break;
        }

        // Llamamos a la acción si existe
        if (method_exists($ctrl, $accion)) {
            $ctrl->$accion($_POST);
        } else {
            echo "Acción '$accion' no encontrada en el controlador '$controlador'.";
        }
    }
}
?>
