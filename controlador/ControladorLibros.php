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
        // Aquí iría la vista
        include("../vista/VistaLibros.php");
    }

    // VER UN LIBRO POR ID
    public function ver($id)
    {
        $libro = $this->libroModel->getById($id);
        include("../vista/VistaLibroDetalle.php");
    }

    // CREAR NUEVO LIBRO
    public function crear($datos)
    {
        $this->libroModel->create($datos);
        // Redirigir a listar
        $this->listar();
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

