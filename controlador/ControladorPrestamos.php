<?php
require_once(__DIR__ . "/../modelo/Prestamo.php");
require_once(__DIR__ . "/../modelo/Ejemplar.php");
require_once(__DIR__ . "/../modelo/Usuario.php");

class ControladorPrestamos
{
    private $prestamoModel;
    private $ejemplarModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->prestamoModel = new Prestamo();
        $this->ejemplarModel = new Ejemplar();
        $this->usuarioModel = new Usuario();
    }

    // LISTAR PRÉSTAMOS
    public function listar($get = [], $post = [])
    {
        $soloPendientes = $get['pendientes'] ?? false;

        if ($soloPendientes) {
            $prestamos = $this->prestamoModel->getPendientesConEstado();
        } else {
            $prestamos = $this->prestamoModel->getAllConEstado();
        }

        include(__DIR__ . "/../vista/VistaPrestamos.php");
    }

    // CREAR PRÉSTAMO
    public function crear($get = [], $post = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'cedula' => $post['cedula'],
                'id_ejemplar' => $post['id_ejemplar'],
                'fecha_prestamo' => $post['fecha_prestamo'],
                'fecha_prevista_devolucion' => $post['fecha_prevista_devolucion']
            ];
            $this->prestamoModel->create($datos);
            header("Location: index.php?controlador=prestamos&accion=listar");
            exit;
        } else {
            $usuarios = $this->usuarioModel->getAll();
            //$ejemplares = $this->ejemplarModel->getDisponibles();
            include(__DIR__ . "/../vista/formularioPrestamo.php");
        }
    }

    // DEVOLVER/EDITAR PRÉSTAMO
    public function marcarDevuelto($get = [], $post = [])
    {
        $id = $get['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'id_prestamo' => $post['id_prestamo'],       // oculto en el form
                'id_ejemplar' => $post['id_ejemplar'],       // oculto también
                'fecha_devolucion' => $post['fecha_devolucion']
            ];
            $this->prestamoModel->marcarDevuelto($datos);
            header("Location: index.php?controlador=prestamos&accion=listar");
            exit;
        } else {
            // cuando entra por GET (mostrar formulario)
            $prestamo = $this->prestamoModel->getById($id);
            include(__DIR__ . "/../vista/formularioDevolucion.php");
        }
    }

    // ELIMINAR PRÉSTAMO
    public function eliminar($get = [])
    {
        $id = $get['id'] ?? null;
        if ($id) {
            $this->prestamoModel->delete($id);
        }
        header("Location: index.php?controlador=prestamos&accion=listar");
        exit;
    }
}
?>
