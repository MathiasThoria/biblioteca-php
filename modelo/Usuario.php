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

    // OBTENER TODOS LOS USUARIOS (CON BUSCADOR)
    public function getAll($busqueda = null)
    {
        $this->set_names();
        
        // --- INICIO DE LA modi ---
        $sql = "SELECT * FROM usuario";
        
        if ($busqueda) {
            $termino = "%" . $busqueda . "%";
            // Buscamos por cédula (que es un CHAR) o por nombre
            $sql .= " WHERE cedula LIKE ? OR nombre LIKE ?";
        }

        $stmt = mysqli_prepare($this->dbh, $sql);
        
        if ($busqueda) {
            // "ss" porque buscamos en dos campos de texto (char y varchar)
            mysqli_stmt_bind_param($stmt, "ss", $termino, $termino);
        }
        
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (!$resultado) {
            die("Error al listar usuarios: " . mysqli_error($this->dbh));
        }

        $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $usuarios;
        // --- FIN DE LA modi ---
    }

   // OBTENER USUARIO POR CÉDULA (CON DATOS DE LOGIN)
    public function getByCedula($cedula)
    {
        $this->set_names();
        $sql = "SELECT u.*, l.perfil, l.contrasena 
                FROM usuario u
                LEFT JOIN login l ON u.cedula = l.id_usuario
                WHERE u.cedula = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cedula); // Cédula es char, usamos 's'
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
        
        // 1. Actualizar tabla 'usuario'
        $sql1 = "UPDATE usuario SET nombre = ?, direccion = ? WHERE cedula = ?";
        $stmt1 = mysqli_prepare($this->dbh, $sql1);
        mysqli_stmt_bind_param($stmt1, "sss", $datos['nombre'], $datos['direccion'], $cedula);
        if (!mysqli_stmt_execute($stmt1)) {
            die("Error al actualizar usuario: " . mysqli_stmt_error($stmt1));
        }
        mysqli_stmt_close($stmt1);

        // 2. Actualizar tabla 'login' (perfil y contraseña)
        // Solo actualiza la contraseña SI se proporcionó una nueva
        if (!empty($datos['contrasena'])) {
            $sql2 = "UPDATE login SET perfil = ?, contrasena = ? WHERE id_usuario = ?";
            $stmt2 = mysqli_prepare($this->dbh, $sql2);
            mysqli_stmt_bind_param($stmt2, "sss", $datos['perfil'], $datos['contrasena'], $cedula);
        } else {
            // Si la contraseña vino vacía, no la actualiza (mantiene la existente)
            $sql2 = "UPDATE login SET perfil = ? WHERE id_usuario = ?";
            $stmt2 = mysqli_prepare($this->dbh, $sql2);
            mysqli_stmt_bind_param($stmt2, "ss", $datos['perfil'], $cedula);
        }
        
        if (!mysqli_stmt_execute($stmt2)) {
            die("Error al actualizar login: " . mysqli_stmt_error($stmt2));
        }
        mysqli_stmt_close($stmt2);
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
