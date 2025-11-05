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
}
?>
<?php

//SINGLETON
// Habitulamente existirian dos metodos: getConexion y getInstancia. 
// Se decide dejar solo getConexion para simplificar el acceso a la conexion.

class Conexion {
    private static $conexion = null;

    private function __construct() {
        // Constructor privado: evita instanciar directamente
    }

    public static function getConexion() {
        // Si no existe, se crea una sola vez
        if (self::$conexion == null) {
            self::$conexion = mysqli_connect("localhost", "root", "root", "biblioteca");
            if (!self::$conexion) {
                die("Error al conectar: " . mysqli_connect_error());
            }
            mysqli_set_charset(self::$conexion, "utf8");
        }
        // Siempre devuelve la misma conexión
        return self::$conexion;
    }
}
?><?php

/**
 * Modelo Prestamo
 *
 * Gestiona los préstamos de ejemplares de libros en la biblioteca.
 *
 * Campos de fechas:
 * - fecha_prestamo: la fecha en que se realiza el préstamo.
 * - fecha_prevista_devolucion: la fecha en que se espera que el ejemplar sea devuelto.
 *   Se calcula al momento de crear el préstamo (por ejemplo, 7 días después de la fecha_prestamo).
 * - fecha_devolucion: la fecha real en que el ejemplar fue devuelto. Puede ser NULL si aún no se ha devuelto.
 */


require_once("Conexion.php");

class Prestamo
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

    // LISTAR TODOS LOS PRÉSTAMOS
    public function getAll()
    {
        $this->set_names();
        $sql = "SELECT * FROM prestamo ORDER BY fecha_prestamo DESC";
        $resultado = $this->dbh->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllConEstado(){
        $this->set_names();
        $sql = "SELECT 
            p.*, 
            u.nombre AS nombre_usuario,
            l.titulo AS titulo_libro,
            e.estado AS estado_ejemplar
            FROM prestamo p
            JOIN usuario u ON p.cedula = u.cedula
            JOIN ejemplar e ON p.id_ejemplar = e.id_ejemplar
            JOIN libros l ON e.id_libro = l.id";
        $resultado = $this->dbh->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }



    // OBTENER PRÉSTAMO POR ID
    public function getById($id)
    {
        $this->set_names();
        $sql = "SELECT * FROM prestamo WHERE id_prestamo = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $prestamo = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $prestamo;
    }

    // CREAR NUEVO PRÉSTAMO
    public function create($datos)
    {
        $this->set_names();
        $sql = "INSERT INTO prestamo (cedula, id_ejemplar, fecha_prestamo, fecha_prevista_devolucion) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "iiss",
            $datos['cedula'],
            $datos['id_ejemplar'],
            $datos['fecha_prestamo'],
            $datos['fecha_prevista_devolucion']
        );
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al insertar préstamo: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        // Marcar el ejemplar como prestado
        $sql2 = "UPDATE ejemplar 
                SET estado = 'prestado' 
                WHERE id_ejemplar = ?";
        $stmt2 = mysqli_prepare($this->dbh, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $datos['id_ejemplar']);

        if (!mysqli_stmt_execute($stmt2)) {
            die("Error al actualizar estado del ejemplar: " . mysqli_stmt_error($stmt2));
        }
        mysqli_stmt_close($stmt2);
    }

    // ACTUALIZAR DEVOLUCIÓN
    public function marcarDevuelto($datos)
    {
        $this->set_names();

        // Actualizar la fecha de devolución del préstamo
        $sql = "UPDATE prestamo 
                SET fecha_devolucion = ? 
                WHERE id_prestamo = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "si", $datos['fecha_devolucion'], $datos['id_prestamo']);

        if (!mysqli_stmt_execute($stmt)) {
            die("Error al actualizar devolución: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        // Marcar el ejemplar como disponible
        $sql2 = "UPDATE ejemplar 
                SET estado = 'disponible' 
                WHERE id_ejemplar = ?";
        $stmt2 = mysqli_prepare($this->dbh, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $datos['id_ejemplar']);

        if (!mysqli_stmt_execute($stmt2)) {
            die("Error al actualizar estado del ejemplar: " . mysqli_stmt_error($stmt2));
        }
        mysqli_stmt_close($stmt2);
    }

    // ELIMINAR PRÉSTAMO
    public function delete($id)
    {
        $this->set_names();
        $sql = "DELETE FROM prestamo WHERE id_prestamo = ?";
        $stmt = mysqli_prepare($this->dbh, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (!mysqli_stmt_execute($stmt)) {
            die("Error al eliminar préstamo: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    }
    // LISTAR PRÉSTAMOS PENDIENTES
    public function getPendientes()
    {
        $this->set_names();
        $sql = "SELECT p.*, u.nombre AS nombre_usuario, u.apellido AS apellido_usuario, e.id_libro
                FROM prestamo p
                JOIN usuario u ON p.cedula = u.cedula
                JOIN ejemplar e ON p.id_ejemplar = e.id_ejemplar
                WHERE p.fecha_devolucion IS NULL
                ORDER BY p.fecha_prevista_devolucion ASC";

        $resultado = $this->dbh->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function getPendientesConEstado()
    {
        $this->set_names();
        $sql = "SELECT 
                    p.*, 
                    u.nombre AS nombre_usuario, 
                    u.apellido AS apellido_usuario, 
                    e.id_libro,
                    e.estado AS estado_ejemplar,
                    l.titulo AS titulo_libro
                FROM prestamo p
                JOIN usuario u ON p.cedula = u.cedula
                JOIN ejemplar e ON p.id_ejemplar = e.id_ejemplar
                JOIN libros l ON e.id_libro = l.id
                WHERE p.fecha_devolucion IS NULL
                ORDER BY p.fecha_prevista_devolucion ASC";

        $resultado = $this->dbh->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
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

        if (!$id_libro) {
            echo "No se especificó un libro.";
            return;
        }

        $libro = $this->libroModel->getById($id_libro);
        $ejemplares = $this->ejemplarModel->getByLibro($id_libro);

        include(__DIR__ . '/../vista/VistaEjemplares.php');
    }

    // FORMULARIO COMÚN PARA CREAR Y EDITAR
    private function formulario($ejemplar = null, $id_libro = null)
    {
        if ($ejemplar) {
            // Si es edición
            $id_ejemplar = $ejemplar['id_ejemplar'];
            $estado = $ejemplar['estado'];
            $id_libro = $ejemplar['id_libro'];
            $accion = 'editar';
        } else {
            // Si es creación
            $id_ejemplar = '';
            $estado = 'disponible';
            $accion = 'crear';
        }

        include(__DIR__ . "/../vista/formularioEjemplar.php");
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
        }

        $id_libro = $get['id_libro'] ?? null;
        $this->formulario(null, $id_libro);
    }

    // EDITAR EJEMPLAR
    public function editar($get = [], $post = [])
    {
        $id_ejemplar = $get['id_ejemplar'] ?? null;

        if (!$id_ejemplar) {
            echo "No se especificó un ejemplar.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = ['estado' => $post['estado']];
            $this->ejemplarModel->update($id_ejemplar, $datos);
            header("Location: index.php?controlador=ejemplares&accion=listar&id_libro=" . $post['id_libro']);
            exit;
        }

        $ejemplar = $this->ejemplarModel->getById($id_ejemplar);
        $this->formulario($ejemplar);
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
<?php
require_once(__DIR__ . "/../modelo/Usuario.php");

class ControladorUsuarios
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    // LISTAR USUARIOS
    public function listar($get = [], $post = [])
    {
        $usuarios = $this->usuarioModel->getAll();
        include(__DIR__ . "/../vista/VistaUsuarios.php");
    }

    // VER USUARIO POR CÉDULA
    public function ver($get = [])
    {
        $cedula = $get['cedula'] ?? null;
        if ($cedula) {
            $usuario = $this->usuarioModel->getByCedula($cedula);
            include(__DIR__ . "/../vista/VistaUsuarioDetalle.php");
        } else {
            echo "No se especificó un usuario.";
        }
    }

    // CREAR NUEVO USUARIO
    public function crear($get = [], $post = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'cedula'  => $post['cedula'],
                'nombre'  => $post['nombre'],
                'apellido'=> $post['apellido']
            ];
            $this->usuarioModel->create($datos);
            header("Location: index.php?controlador=usuarios&accion=listar");
            exit;
        } else {
            $usuario = null; // para el formulario vacío
            include(__DIR__ . "/../vista/formularioUsuario.php");
        }
    }

    // EDITAR USUARIO
    public function editar($get = [], $post = [])
    {
        $cedula = $get['cedula'] ?? null;
        if (!$cedula) {
            echo "No se especificó un usuario.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'nombre'   => $post['nombre'],
                'apellido' => $post['apellido']
            ];
            $this->usuarioModel->update($cedula, $datos);
            header("Location: index.php?controlador=usuarios&accion=listar");
            exit;
        } else {
            $usuario = $this->usuarioModel->getByCedula($cedula);
            include(__DIR__ . "/../vista/formularioUsuario.php");
        }
    }

    // ELIMINAR USUARIO
    public function eliminar($get = [])
    {
        $cedula = $get['cedula'] ?? null;
        if ($cedula) {
            $this->usuarioModel->delete($cedula);
        }
        header("Location: index.php?controlador=usuarios&accion=listar");
        exit;
    }
}
?>
<?php
require_once(__DIR__ . "/../modelo/Prestamo.php");
require_once(__DIR__ . "/../modelo/Ejemplar.php");
require_once(__DIR__ . "/../modelo/Usuario.php");

class ControladorPrestamos
{
    private $prestamoModel;
    private $ejemplarModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->prestamoModel = new Prestamo();
        $this->ejemplarModel = new Ejemplar();
        $this->usuarioModel = new Usuario();
    }

    // LISTAR PRÉSTAMOS
    public function listar($get = [], $post = [])
    {
        $soloPendientes = $get['pendientes'] ?? false;

        if ($soloPendientes) {
            $prestamos = $this->prestamoModel->getPendientesConEstado();
        } else {
            $prestamos = $this->prestamoModel->getAllConEstado();
        }

        include(__DIR__ . "/../vista/VistaPrestamos.php");
    }

    // CREAR PRÉSTAMO
    public function crear($get = [], $post = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'cedula' => $post['cedula'],
                'id_ejemplar' => $post['id_ejemplar'],
                'fecha_prestamo' => $post['fecha_prestamo'],
                'fecha_prevista_devolucion' => $post['fecha_prevista_devolucion']
            ];
            $this->prestamoModel->create($datos);
            header("Location: index.php?controlador=prestamos&accion=listar");
            exit;
        } else {
            $usuarios = $this->usuarioModel->getAll();
            //$ejemplares = $this->ejemplarModel->getDisponibles();
            include(__DIR__ . "/../vista/formularioPrestamo.php");
        }
    }

    // DEVOLVER/EDITAR PRÉSTAMO
    public function marcarDevuelto($get = [], $post = [])
    {
        $id = $get['id'] ?? null;
/*var_dump($_SERVER['REQUEST_METHOD'], $get, $post);
die();*/
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($post)) {
            $datos = [
                'id_prestamo' => $post['id_prestamo'],       // oculto en el form
                'id_ejemplar' => $post['id_ejemplar'],       // oculto también
                'fecha_devolucion' => $post['fecha_devolucion']
            ];
            $this->prestamoModel->marcarDevuelto($datos);
            header("Location: index.php?controlador=prestamos&accion=listar");
            exit;
        } else {
            // cuando entra por GET (mostrar formulario)
            $prestamo = $this->prestamoModel->getById($id);
            include(__DIR__ . "/../vista/formularioDevolucion.php");
        }
    }

    // ELIMINAR PRÉSTAMO
    public function eliminar($get = [])
    {
        $id = $get['id'] ?? null;
        if ($id) {
            $this->prestamoModel->delete($id);
        }
        header("Location: index.php?controlador=prestamos&accion=listar");
        exit;
    }
}
?>
<?php
class ControladorFrente {

    public function ejecutar($controlador, $accion) {
        switch($controlador) {
            case 'libros':
                require_once("ControladorLibros.php");
                $ctrl = new ControladorLibros();
                break;

            case 'usuarios':
                require_once("ControladorUsuarios.php");
                $ctrl = new ControladorUsuarios();
                break;

            case 'prestamos':
                require_once("ControladorPrestamos.php");
                $ctrl = new ControladorPrestamos();
                break;
            case 'ejemplares':
                require_once("ControladorEjemplares.php");
                $ctrl = new ControladorEjemplares();
                break;
            case 'general':
            default:
                include(__DIR__."/../vista/VistaMenu.php");
                return;
                break;
        }

        
        if (method_exists($ctrl, $accion)) {
            $ctrl->$accion($_GET, $_POST);
        } else {
            echo "Acción '$accion' no encontrada en el controlador '$controlador'.";
        }
    }
}
?>
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
?><?php
// formularioUsuario.php

// Si existen datos del usuario (modo edición), los tomamos.
// Si no, dejamos los campos vacíos (modo alta).
$cedula = $usuario['cedula'] ?? '';
$nombre = $usuario['nombre'] ?? '';
$apellido = $usuario['apellido'] ?? '';

// Si estamos editando, el formulario se enviará a "editar",
// si no, a "crear".
$accion = isset($usuario) ? 'editar' : 'crear';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($usuario) ? 'Editar Usuario' : 'Agregar Usuario' ?></title>
    <style>
        form {
            width: 320px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, button {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        button {
            cursor: pointer;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">
    <?= isset($usuario) ? 'Editar Usuario' : 'Agregar Nuevo Usuario' ?>
</h2>

<form action="index.php?controlador=usuarios&accion=<?= $accion ?>" method="POST">
    <label for="cedula">Cédula:</label>
    <input type="number" name="cedula" id="cedula" value="<?= htmlspecialchars($cedula) ?>" 
           <?= isset($usuario) ? 'readonly' : 'required' ?>>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($apellido) ?>" required>

    <button type="submit">
        <?= isset($usuario) ? 'Guardar Cambios' : 'Agregar Usuario' ?>
    </button>

    <a href="index.php?controlador=usuarios&accion=listar">Cancelar</a>
</form>
<a href="index.php?controlador=usuario&accion=listar">⬅ Volver a la lista</a>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca - Menú Principal</title>
</head>
<body>
    <h1>Bienvenido al Sistema de Biblioteca</h1>
    <ul>
        <li><a href="index.php?controlador=libros&accion=listar">Libros</a></li>
        <li><a href="index.php?controlador=prestamos&accion=listar">Préstamos</a></li>
        <li><a href="index.php?controlador=usuarios&accion=listar">Usuarios</a></li>
    </ul>
</body>
</html><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar devolución</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            text-align: center;
        }
        form {
            display: inline-block;
            background: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 40px;
        }
        input {
            padding: 6px;
            width: 220px;
            margin-bottom: 12px;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }
        input[readonly] {
            background-color: #eee;
            color: #555;
        }
        button {
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background-color: #45a049; }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>

<h2>Registrar devolución</h2>

<form action="index.php?controlador=prestamos&accion=marcarDevuelto" method="POST">
    <input type="hidden" name="id_prestamo" value="<?= $prestamo['id_prestamo'] ?>">

    <label for="cedula">Cédula del usuario:</label>
    <input type="number" id="cedula" value="<?= $prestamo['cedula'] ?>" readonly>

    <label for="id_ejemplar">ID del ejemplar:</label>
    <input type="number" name="id_ejemplar" id="id_ejemplar" value="<?= $prestamo['id_ejemplar'] ?>" readonly>

    <label for="fecha_prestamo">Fecha del préstamo:</label>
    <input type="date" id="fecha_prestamo" value="<?= $prestamo['fecha_prestamo'] ?>" readonly>

    <label for="fecha_prevista_devolucion">Fecha prevista de devolución:</label>
    <input type="date" id="fecha_prevista_devolucion" value="<?= $prestamo['fecha_prevista_devolucion'] ?>" readonly>

    <label for="fecha_devolucion">Fecha de devolución:</label>
    <input type="date" name="fecha_devolucion" id="fecha_devolucion" value="<?= date('Y-m-d') ?>" required>

    <br>
    <button type="submit">Registrar devolución</button>
</form>

<br>
<a href="index.php?controlador=prestamos&accion=listar">⬅ Volver a la lista</a>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Libros</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        a {
            margin: 0 5px;
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Gestión de Libros</h2>

<a href="index.php?controlador=general">⬅ Volver al Menu</a>
<?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'administrador'): ?>
    <div style="text-align:center; margin-bottom: 20px;">
        <a href="index.php?controlador=libros&accion=crear">Agregar Libro</a>        
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Id</th>            
            <th>ISBN</th>
            <th>Título</th>
            <th>Autor</th>            
            <th>Editorial</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>                    
                    <td><?php echo $libro['isbn']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>                    
                    <td><?php echo $libro['editorial']; ?></td>
                    <td>
                        <a href="index.php?controlador=libros&accion=ver&id=<?php echo $libro['id']; ?>">Ver</a>     
                        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'administrador'): ?>
                            <a href="index.php?controlador=libros&accion=editar&id=<?php echo $libro['id']; ?>">Editar</a>
                            <a href="index.php?controlador=libros&accion=eliminar&id=<?php echo $libro['id']; ?>"
                                onclick="return confirm('¿Seguro que quieres eliminar este libro?')">Eliminar</a>
                            <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $libro['id']; ?>">Ejemplares</a>
                        <?php endif; ?>                  
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">No hay libros registrados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
<?php
// formulario_libro.php

// Si $libro viene del controlador, se usan sus valores; si no, se deja vacío
$titulo = isset($libro['titulo']) ? $libro['titulo'] : '';
$autor  = isset($libro['autor'])  ? $libro['autor']  : '';
$isbn   = isset($libro['isbn'])   ? $libro['isbn']   : '';
$id     = isset($libro['id'])     ? $libro['id']     : '';
$editorial = isset($libro['editorial']) ? $libro['editorial'] : '';
$accion = $id ? 'editar&id=' . $id : 'crear';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? "Editar Libro" : "Agregar Libro"; ?></title>
    <style>
        form {
            width: 400px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        button, a {
            margin-top: 15px;
            padding: 6px 12px;
            text-decoration: none;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;"><?php echo $id ? "Editar Libro" : "Agregar Libro"; ?></h2>




<form action="index.php?controlador=libros&accion=<?php echo $accion; ?>" method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>

    <label>Autor:</label>
    <input type="text" name="autor" value="<?php echo htmlspecialchars($autor); ?>" required>

    <label>ISBN:</label>
    <input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required>
    
    <label>Editorial:</label>
    <input type="text" name="editorial" value="<?php echo htmlspecialchars($editorial); ?>" required>

    <div style="margin-top:15px;">
        <button type="submit"><?php echo $id ? "Actualizar" : "Guardar"; ?></button>
        <a href="index.php?controlador=libros&accion=listar">Cancelar</a>
    </div>
</form>
<a href="index.php?controlador=libros&accion=listar">⬅ Volver a la lista</a>
</body>
</html>
<h2 style="text-align:center;">Gestión de Ejemplares</h2>

<?php if (isset($libro)): ?>
    <p style="text-align:center;">
        Ejemplares del libro: <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong> 
        (ID: <?php echo $libro['id']; ?>)
    </p>
<?php endif; ?>
<a href="index.php?controlador=prestamos&accion=listar">⬅ Volver a la lista Prestamos</a>
<a href="index.php?controlador=general">⬅ Volver al Menu</a>
<div style="text-align:center; margin-bottom: 15px;">
    <a href="index.php?controlador=ejemplares&accion=crear&id_libro=<?php echo $libro['id']; ?>">
        Agregar Ejemplar
    </a>
</div>

<table border="1" style="width:60%; margin:0 auto; border-collapse:collapse;">
    <thead>
        <tr>
            <th>ID Ejemplar</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($ejemplares)): ?>
            <?php foreach ($ejemplares as $ej): ?>
                <tr>
                    <td><?php echo $ej['id_ejemplar']; ?></td>
                    <td><?php echo $ej['estado']; ?></td>
                    <td>
                        <a href="index.php?controlador=ejemplares&accion=editar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>">Editar</a>
                        <a href="index.php?controlador=ejemplares&accion=eliminar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>&id_libro=<?php echo $libro['id']; ?>" 
                        onclick="return confirm('¿Seguro que querés eliminar este ejemplar?');">Eliminar</a>    
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No hay ejemplares registrados</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php
// VistaPrestamos.php

// $prestamos viene del controlador
// $filtro_estado viene del controlador o $_GET
$filtro_estado = $filtro_estado ?? 'todos';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Préstamos</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        form {
            text-align: center;
            margin-top: 20px;
        }
        select, button {
            padding: 5px 10px;
            margin-left: 5px;
        }
        .vencido { color: red; font-weight: bold; }
        .pendiente { color: orange; font-weight: bold; }
        .devuelto { color: green; font-weight: bold; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Gestión de Préstamos</h2>
<a href="index.php?controlador=general">⬅ Volver al Menu</a>
<!-- Filtro de préstamos -->
<form action="index.php" method="GET">
    <input type="hidden" name="controlador" value="prestamos">
    <input type="hidden" name="accion" value="listar">

    <label>Mostrar:</label>
    <select name="filtro_estado">
        <option value="todos" <?= ($filtro_estado=='todos') ? 'selected' : '' ?>>Todos</option>
        <option value="pendientes" <?= ($filtro_estado=='pendientes') ? 'selected' : '' ?>>Pendientes</option>
    </select>
    <button type="submit">Aplicar</button>
</form>

<!-- Botón para nuevo préstamo -->
<a href="index.php?controlador=prestamos&accion=crear">
    Ingresar Préstamo
</a>
<table>
    <tr>
        <th>Usuario (CI)</th>
        <th>Ejemplar (ID)</th>
        <th>Fecha Préstamo</th>
        <th>Fecha Prevista Devolución</th>
        <th>Fecha Devolución</th>
        <th>Estado (Ejemplar)</th>
        <th>Acciones</th>
    </tr>

    <?php if (!empty($prestamos)): ?>
        <?php foreach ($prestamos as $p): ?>
            <?php
            // Calcular estado
            $hoy = new DateTime();
            $fecha_prevista = new DateTime($p['fecha_prevista_devolucion']);
            $fecha_devuelto = !empty($p['fecha_devolucion']) ? new DateTime($p['fecha_devolucion']) : null;

            if ($p['estado_ejemplar'] === 'disponible') {
                $estado = 'Devuelto';
            } 
            if($fecha_prevista < $hoy && $p['estado_ejemplar'] === 'prestado') {
                $estado = 'Vencido';
            }
            if($fecha_prevista >= $hoy && $p['estado_ejemplar'] === 'prestado'){
                $estado = 'Pendiente';
            }
            ?>
            <tr>
                <td><?= htmlspecialchars($p['cedula']) ?></td>
                <td><?= $p['id_ejemplar'] ?></td>                
                <td><?= $p['fecha_prestamo'] ?></td>
                <td><?= $p['fecha_prevista_devolucion'] ?></td>
                <td><?= $p['fecha_devolucion'] ?? '-' ?></td>
                <td class="<?= $p['estado_ejemplar'] ?>">
                <?= $estado ?></td>
                <td>
                    <?php if ($estado == 'Pendiente' || $estado == 'Vencido'): ?>
                        <a href="index.php?controlador=prestamos&accion=marcarDevuelto&id=<?= $p['id_prestamo'] ?>">Devolver</a>
                    <?php endif; ?>
                    &nbsp;|&nbsp;
                    <a href="index.php?controlador=prestamos&accion=eliminar&id=<?= $p['id_prestamo'] ?>"
                       onclick="return confirm('¿Seguro que querés eliminar este préstamo?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="8">No hay préstamos para mostrar.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
<?php
// VistaPrestamoNuevo.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Préstamo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            text-align: center;
        }
        form {
            display: inline-block;
            background: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 40px;
        }
        input {
            padding: 6px;
            width: 220px;
            margin-bottom: 12px;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 10px;
            font-weight: bold;
        }
        button {
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background-color: #45a049; }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>

<h2>Registrar nuevo préstamo</h2>

<form action="index.php?controlador=prestamos&accion=crear" method="POST">
    <input type="hidden" name="controlador" value="prestamos">
    <input type="hidden" name="accion" value="guardar">

    <label for="cedula">Cédula del usuario:</label>
    <input type="number" name="cedula" id="cedula" placeholder="Ej: 52345678" required>

    <label for="id_ejemplar">ID del ejemplar:</label>
    <input type="number" name="id_ejemplar" id="id_ejemplar" placeholder="Ej: 15" required>

    <label for="fecha_prestamo">Fecha del préstamo:</label>
    <input type="date" name="fecha_prestamo" id="fecha_prestamo" value="<?= date('Y-m-d') ?>" required>

    <label for="fecha_prevista_devolucion">Fecha prevista de devolución:</label>
    <input type="date" name="fecha_prevista_devolucion" id="fecha_prevista_devolucion" required>

    <br>
    <button type="submit">Guardar préstamo</button>
</form>

<br>
<a href="index.php?controlador=prestamos&accion=listar">⬅ Volver a la lista</a>

</body>
</html>
<?php
// VistaUsuarios.php

// $usuarios viene del controlador
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        a {
            text-decoration: none;
            color: blue;
            margin: 0 4px;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-agregar {
            display: block;
            width: 150px;
            margin: 20px auto;
            text-align: center;
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .btn-agregar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Usuarios</h2>
<a href="index.php?controlador=general">⬅ Volver al Menu</a>
<a href="index.php?controlador=usuarios&accion=crear" class="btn-agregar">Agregar Usuario</a>

<table>
    <tr>
        <th>Cédula</th>
        <th>Nombre</th>
        <th>Direccion</th>
        <th>Acciones</th>
    </tr>

    <?php if (!empty($usuarios)): ?>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['cedula']) ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['direccion']) ?></td>
                <td>
                    <a href="index.php?controlador=usuarios&accion=ver&cedula=<?= $u['cedula'] ?>">Ver</a> |
                    <a href="index.php?controlador=usuarios&accion=editar&cedula=<?= $u['cedula'] ?>">Editar</a> |
                    <a href="index.php?controlador=usuarios&accion=eliminar&cedula=<?= $u['cedula'] ?>"
                       onclick="return confirm('¿Seguro que querés eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="4">No hay usuarios para mostrar.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
// formularioEjemplar.php

// $ejemplar viene del controlador cuando es edición
$id_libro = $ejemplar['id_libro'] ?? $id_libro ?? '';
$estado   = $ejemplar['estado'] ?? 'disponible';
$accion   = isset($ejemplar) ? "editar&id_ejemplar=" . $ejemplar['id_ejemplar'] : "crear";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($ejemplar) ? "Editar Ejemplar" : "Agregar Ejemplar"; ?></title>
    <style>
        form {
            width: 300px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select, button, a {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
            text-decoration: none;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;"><?php echo isset($ejemplar) ? "Editar Ejemplar" : "Agregar Ejemplar"; ?></h2>

<form action="index.php?controlador=ejemplares&accion=<?php echo $accion; ?>" method="POST">
    <input type="hidden" name="id_libro" value="<?php echo htmlspecialchars($id_libro); ?>">

    <label>Estado:</label>
    <select name="estado" required>
        <option value="disponible" <?php echo $estado=='disponible' ? 'selected' : ''; ?>>Disponible</option>
        <option value="prestado" <?php echo $estado=='prestado' ? 'selected' : ''; ?>>Prestado</option>
    </select>

    <button type="submit"><?php echo isset($ejemplar) ? "Actualizar" : "Agregar"; ?></button>
    <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $id_libro; ?>">Cancelar</a>
</form>
<a href="index.php?controlador=ejemplares&accion=listar">⬅ Volver a la lista</a>
</body>
</html>
<?php

session_start(); // iniciar sesión

// Mockear un usuario administrador para pruebas
if (!isset($_SESSION['tipo'])) {
    $_SESSION['usuario'] = 'admin';
    $_SESSION['tipo'] = 'administrador';
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// index.php
require_once("controlador/ControladorFrente.php");

$controladorFrente = new ControladorFrente();

// Obtenemos parámetros de URL, por defecto a 'inicio'
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'general';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

// Delegamos al controlador frente
$controladorFrente->ejecutar($controlador, $accion);

?>