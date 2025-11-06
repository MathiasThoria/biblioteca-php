<?php

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
        
        // Consultar si ejemplar disponible
        
        $sqlCheck = "SELECT estado FROM ejemplar WHERE id_ejemplar = ?";
        $stmtCheck = mysqli_prepare($this->dbh, $sqlCheck);
        mysqli_stmt_bind_param($stmtCheck, "i", $datos['id_ejemplar']);
        mysqli_stmt_execute($stmtCheck);
        $resultado = mysqli_stmt_get_result($stmtCheck);
        $ejemplar = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmtCheck);

        if (!$ejemplar) {
            return ["error" => true, "mensaje" => "El ejemplar no existe"];
        }

        if ($ejemplar['estado'] !== 'disponible') {
            return ["error" => true, "mensaje" => "El ejemplar no está disponible"];
        }       
        
        
        $sql1 = "INSERT INTO prestamo (cedula, id_ejemplar, fecha_prestamo, fecha_prevista_devolucion) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbh, $sql1);
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
        $sql1 = "UPDATE prestamo 
                SET fecha_devolucion = ? 
                WHERE id_prestamo = ?";
        $stmt = mysqli_prepare($this->dbh, $sql1);
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
