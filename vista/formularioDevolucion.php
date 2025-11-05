<!DOCTYPE html>
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
