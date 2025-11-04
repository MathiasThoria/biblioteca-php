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
        return mysqli_set_charset($this->dbh, "utf8");
    }

    // LISTAR TODOS LOS LIBROS
    public function getAll()
    {
        self::set_names();
        $this->libros = array();
        $sql = "SELECT * FROM libros";
        $resultado = mysqli_query($this->dbh, $sql);
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $this->libros[] = $fila;
            }
        } else {
            die("Error al listar libros: " . mysqli_error($this->dbh));
        }
        return $this->libros;
    }

    // OBTENER LIBRO POR ID
    public function getById($id)
    {
        self::set_names();
        $sql = "SELECT * FROM libros WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $libro = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $libro;
    }

    // CREAR NUEVO LIBRO
    public function create($datos)
    {
        self::set_names();
        $sql = "INSERT INTO libros (titulo, autor, isbn, editorial) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $datos['titulo'], $datos['autor'], $datos['isbn'], $datos['editorial']);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al insertar libro: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // EDITAR LIBRO
    public function update($id, $datos)
    {
        self::set_names();
        $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, editorial = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $datos['titulo'], $datos['autor'], $datos['isbn'], $datos['editorial'], $id);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al actualizar libro: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // ELIMINAR LIBRO
    public function delete($id)
    {
        self::set_names();
        $sql = "DELETE FROM libros WHERE id = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al eliminar libro: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }
}
?>
