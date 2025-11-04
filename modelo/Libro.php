<?php
require_once("Conexion.php");
class Libro
{
    private $libros; // colección de libros
    private $dbh;    // conexión a la base de datos

    public function __construct()
    {
        $this->libros = array();
        $this->dbh = Conexion::getConexion();
        
    }

    private function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    // LISTAR TODOS LOS LIBROS
    public function getAll()
    {
        self::set_names();
        $sql = "SELECT * FROM libros"; 
        foreach ($this->dbh->query($sql) as $res) {
            $this->libros[] = $res;
        }
        return $this->libros;
        $this->dbh = null; // aunque PDO cierra automáticamente al final
    }

    // OBTENER LIBRO POR ID
    public function getById($id)
    {
        self::set_names();
        $sql = "SELECT * FROM libros WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // CREAR NUEVO LIBRO
    public function create($datos)
    {
        self::set_names();
        $sql = "INSERT INTO libros (titulo, autor, isbn) VALUES (:titulo, :autor, :isbn)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
            'titulo' => $datos['titulo'],
            'autor'  => $datos['autor'],
            'isbn'   => $datos['isbn']
        ]);
    }

    // EDITAR LIBRO
    public function update($id, $datos)
    {
        self::set_names();
        $sql = "UPDATE libros SET titulo = :titulo, autor = :autor, isbn = :isbn WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
            'titulo' => $datos['titulo'],
            'autor'  => $datos['autor'],
            'isbn'   => $datos['isbn'],
            'id'     => $id
        ]);
    }

    // ELIMINAR LIBRO
    public function delete($id)
    {
        self::set_names();
        $sql = "DELETE FROM libros WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}

