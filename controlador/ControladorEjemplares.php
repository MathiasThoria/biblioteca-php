<?php
require_once(__DIR__ . "/../modelo/Ejemplar.php");
require_once(__DIR__ . "/../modelo/Libro.php");

class ControladorEjemplares
{
    private $ejemplarModel;
    private $libroModel;

    public function __construct()
    {
        $this->ejemplarModel = new Ejemplar();
        $this->libroModel = new Libro();
    }

    // LISTAR EJEMPLARES DE UN LIBRO
    public function listar($get = [], $post = [])
    {
        $id_libro = $get['id_libro'] ?? null;

        if (!$id_libro) {
            echo "No se especificó un libro.";
            return;
        }

        $libro = $this->libroModel->getById($id_libro);
        $ejemplares = $this->ejemplarModel->getByLibro($id_libro);

        include(__DIR__ . '/../vista/VistaEjemplares.php');
    }

    // FORMULARIO COMÚN PARA CREAR Y EDITAR
    private function formulario($ejemplar = null, $id_libro = null)
    {
        if ($ejemplar) {
            // Si es edición
            $id_ejemplar = $ejemplar['id_ejemplar'];
            $estado = $ejemplar['estado'];
            $id_libro = $ejemplar['id_libro'];
            $accion = 'editar';
        } else {
            // Si es creación
            $id_ejemplar = '';
            $estado = 'disponible';
            $accion = 'crear';
        }

        include(__DIR__ . "/../vista/formularioEjemplar.php");
    }

    // CREAR NUEVO EJEMPLAR
    public function crear($get = [], $post = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'id_libro' => $post['id_libro'],
                'estado'   => $post['estado']
            ];
            $this->ejemplarModel->create($datos);
            header("Location: index.php?controlador=ejemplares&accion=listar&id_libro=" . $post['id_libro']);
            exit;
        }

        $id_libro = $get['id_libro'] ?? null;
        $this->formulario(null, $id_libro);
    }

    // EDITAR EJEMPLAR
    public function editar($get = [], $post = [])
    {
        $id_ejemplar = $get['id_ejemplar'] ?? null;

        if (!$id_ejemplar) {
            echo "No se especificó un ejemplar.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = ['estado' => $post['estado']];
            $this->ejemplarModel->update($id_ejemplar, $datos);
            header("Location: index.php?controlador=ejemplares&accion=listar&id_libro=" . $post['id_libro']);
            exit;
        }

        $ejemplar = $this->ejemplarModel->getById($id_ejemplar);
        $this->formulario($ejemplar);
    }

    // ELIMINAR EJEMPLAR
    public function eliminar($get = [])
    {
        $id_ejemplar = $get['id_ejemplar'] ?? null;
        $id_libro = $get['id_libro'] ?? null;

        if ($id_ejemplar) {
            $this->ejemplarModel->delete($id_ejemplar);
        }

        header("Location: index.php?controlador=ejemplares&accion=listar&id_libro=" . $id_libro);
        exit;
    }
}
?>
