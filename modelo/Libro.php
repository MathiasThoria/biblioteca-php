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

    // LISTAR TODOS LOS LIBROS (CON BUSCADOR)
    public function getAll($busqueda = null)
    {
        self::set_names();
        $this->libros = array();
        
        // --- INICIO DE LA CORRECCIÓN ---
        $sql = "SELECT * FROM libros";
        
        if ($busqueda) {
            $termino = "%" . $busqueda . "%";
            $sql .= " WHERE titulo LIKE ? OR autor LIKE ?";
        }
        
        $stmt = mysqli_prepare($this->dbh, $sql);
        
        if ($busqueda) {
            mysqli_stmt_bind_param($stmt, "ss", $termino, $termino);
        }
        
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        // --- FIN DE LA CORRECCIÓN ---

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $this->libros[] = $fila;
            }
        } else {
            die("Error al listar libros: " . mysqli_error($this->dbh));
        }
        mysqli_stmt_close($stmt);
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
