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
