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

        // Insertar en tabla usuario
        $sql1 = "INSERT INTO usuario (cedula, nombre, direccion) VALUES (?, ?, ?)";
        $stmt1 = mysqli_prepare($this->dbh, $sql1);
        mysqli_stmt_bind_param($stmt1, "sss", $datos['cedula'], $datos['nombre'], $datos['direccion']);
        if (!mysqli_stmt_execute($stmt1)) {
            die("Error al insertar usuario: " . mysqli_stmt_error($stmt1));
        }
        mysqli_stmt_close($stmt1);

        // Insertar en tabla login
        $perfil = $datos['perfil'] ?? 'usuario';
        $password = $datos['contrasena'] ?? '123'; // contraseña por defecto si no se pasa
        $sql2 = "INSERT INTO login (id_usuario, contrasena, perfil) VALUES (?, ?, ?)";
        $stmt2 = mysqli_prepare($this->dbh, $sql2);
        mysqli_stmt_bind_param($stmt2, "sss", $datos['cedula'], $password, $perfil);
        if (!mysqli_stmt_execute($stmt2)) {
            die("Error al insertar login: " . mysqli_stmt_error($stmt2));
        }
        mysqli_stmt_close($stmt2);
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

        // 1. Eliminar de login
        $sqlLogin = "DELETE FROM login WHERE id_usuario = ?";
        $stmtLogin = mysqli_prepare($this->dbh, $sqlLogin);
        mysqli_stmt_bind_param($stmtLogin, "s", $cedula); // char(8)
        if (!mysqli_stmt_execute($stmtLogin)) {
            die("Error al eliminar login: " . mysqli_stmt_error($stmtLogin));
        }
        mysqli_stmt_close($stmtLogin);

        // 2. Eliminar de usuario
        $sqlUsuario = "DELETE FROM usuario WHERE cedula = ?";
        $stmtUsuario = mysqli_prepare($this->dbh, $sqlUsuario);
        mysqli_stmt_bind_param($stmtUsuario, "s", $cedula); // char(8)
        if (!mysqli_stmt_execute($stmtUsuario)) {
            die("Error al eliminar usuario: " . mysqli_stmt_error($stmtUsuario));
        }
        mysqli_stmt_close($stmtUsuario);
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
