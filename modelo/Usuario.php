<?php
require_once("Conexion.php");

class Usuario
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

    // OBTENER TODOS LOS USUARIOS
    public function getAll()
    {
        $this->set_names();
        $sql = "SELECT * FROM usuario";
        $resultado = $this->dbh->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // OBTENER USUARIO POR CÉDULA
    public function getByCedula($cedula)
    {
        $this->set_names();
        $sql = "SELECT * FROM usuario WHERE cedula = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $cedula);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $usuario;
    }

    // CREAR USUARIO
    public function create($datos)
    {
        $this->set_names();
        $sql = "INSERT INTO usuario (cedula, nombre, apellido) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $datos['cedula'], $datos['nombre'], $datos['direccion']);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al insertar usuario: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // EDITAR USUARIO
    public function update($cedula, $datos)
    {
        $this->set_names();
        $sql = "UPDATE usuario SET nombre = ?, direccion = ? WHERE cedula = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $datos['nombre'], $datos['direccion'], $cedula);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al actualizar usuario: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }

    // ELIMINAR USUARIO
    public function delete($cedula)
    {
        $this->set_names();
        $sql = "DELETE FROM usuario WHERE cedula = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $cedula);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al eliminar usuario: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }
    // VALIDAR LOGIN - tabla login
    public function validarLogin($cedula, $password) {
        $this->set_names();
        $sql = "SELECT * FROM login WHERE id_usuario = ? AND contrasena = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $cedula, $password);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $usuario ? true : false;
    }
}
?>
