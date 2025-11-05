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

        if ($id_libro) {
            // Traer información del libro
            $libro = $this->libroModel->getById($id_libro);

            // Traer los ejemplares asociados
            $ejemplares = $this->ejemplarModel->getByLibro($id_libro);

            // Incluir la vista y pasar $libro y $ejemplares
            include(__DIR__ . '/../vista/VistaEjemplares.php');
        } else {
            echo "No se especificó un libro.";
        }
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
        } else {
            $id_libro = $get['id_libro'] ?? null;
            include(__DIR__ . "/../vista/formularioEjemplar.php");
        }
    }

    // EDITAR EJEMPLAR
    public function editar($get = [], $post = [])
    {
        $id = $get['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = ['estado' => $post['estado']];
            $this->ejemplarModel->update($id, $datos);
            header("Location: index.php?controlador=ejemplares&accion=listar&id_libro=" . $post['id_libro']);
            exit;
        } else {
            $ejemplar = $this->ejemplarModel->getById($id);
            include(__DIR__ . "/../vista/formularioEjemplar.php");
        }
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
