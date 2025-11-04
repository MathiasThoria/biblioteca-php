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
    public function listar()
    {
        $libros = $this->libroModel->getAll();        
        include(__DIR__ . '/../vista/VistaLibros.php');
    }

    // VER UN LIBRO POR ID
    public function ver($id)
    {
        $libro = $this->libroModel->getById($id);
        include("/vista/VistaLibroDetalle.php");
    }

    // CREAR NUEVO LIBRO
    public function crear($datos = null) {
        //var_dump($datos);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($datos)) {
            // Procesar datos y guardar libro
            $this->libroModel->create($datos);
            // $this->modelo->insertar($datos);
      
            header("Location: index.php?controlador=libros&accion=listar");
            //$this->listar();
            exit;
        } else {
            // Mostrar formulario
            $libro = null; // vacío para un libro nuevo
            include(__DIR__ . "/../vista/formularioLibro.php");
        }
    }   

    // EDITAR LIBRO
    public function editar($id, $datos)
    {
        $this->libroModel->update($id, $datos);
        $this->listar();
    }

    // ELIMINAR LIBRO
    public function eliminar($id)
    {
        $this->libroModel->delete($id);
        $this->listar();
    }
}

