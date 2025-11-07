<?php
require_once("Conexion.php");

class Ejemplar
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = Conexion::getConexion();
    }

    private function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    // LISTAR EJEMPLARES DE UN LIBRO
    public function getByLibro($id_libro)
    {
        $this->set_names();
        $sql = "SELECT * FROM ejemplar WHERE id_libro = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_libro);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $ejemplares = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $ejemplares;
    }

    // OBTENER EJEMPLAR POR ID
    public function getById($id)
    {
        $this->set_names();
        $sql = "SELECT * FROM ejemplar WHERE id_ejemplar = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $ejemplar = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $ejemplar;
    }

    // CREAR NUEVO EJEMPLAR
    public function create($datos)
    {
        $this->set_names();
        $sql = "INSERT INTO ejemplar (id_libro, estado) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "is", $datos['id_libro'], $datos['estado']);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al insertar ejemplar: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // EDITAR EJEMPLAR
    public function update($id, $datos)
    {
        $this->set_names();
        $sql = "UPDATE ejemplar SET estado = ? WHERE id_ejemplar = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "si", $datos['estado'], $id);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al actualizar ejemplar: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // ELIMINAR EJEMPLAR
    public function delete($id)
    {
        $this->set_names();
        $sql = "DELETE FROM ejemplar WHERE id_ejemplar = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al eliminar ejemplar: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }
}
?>
