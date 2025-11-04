<?php
require_once(__DIR__ . "/../modelo/Libro.php");

class ControladorLibros
{
    private $libroModel;

    public function __construct()
    {
        $this->libroModel = new Libro();
    }

    // LISTAR TODOS LOS LIBROS
    public function listar($get = [], $post = [])
    {
        $libros = $this->libroModel->getAll();        
        include(__DIR__ . '/../vista/VistaLibros.php');
    }

    // VER UN LIBRO POR ID
    public function ver($get = [], $post = [])
    {
        $id = $get['id'] ?? null;
        $libro = $this->libroModel->getById($id);
        include(__DIR__ . "/../vista/VistaLibroDetalle.php");
    }

    // CREAR NUEVO LIBRO
    public function crear($get = [], $post = []) 
    {
        if (!empty($post)) {
            $this->libroModel->create($post);
            header("Location: index.php?controlador=libros&accion=listar");            
            exit;
        } else {
            $libro = null; // vacío para un libro nuevo
            include(__DIR__ . "/../vista/formularioLibro.php");
        }
    }   

    // EDITAR LIBRO
    public function editar($get = [], $post = [])
    {
        $id = $get['id'] ?? null;
        if (!empty($post)) {
            $datos = [
                'titulo'    => $post['titulo'] ?? '',
                'autor'     => $post['autor'] ?? '',
                'isbn'      => $post['isbn'] ?? '',
                'editorial' => $post['editorial'] ?? ''
            ];
            $this->libroModel->update($id, $datos);
            header("Location: index.php?controlador=libros&accion=listar");
            exit;
        } else {
            $libro = $this->libroModel->getById($id);
            include(__DIR__ . "/../vista/formularioLibro.php");
        }
    }

    // ELIMINAR LIBRO
    public function eliminar($get = [], $post = [])
    {
        $id = $get['id'] ?? null;
        if ($id) {
            $this->libroModel->delete($id);
        }
        header("Location: index.php?controlador=libros&accion=listar");
        exit;
    }
}
?>