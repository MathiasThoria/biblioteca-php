<?php
// formularioEjemplar.php

// $id_libro viene del controlador
$id_libro = $id_libro ?? '';
$estado = 'disponible'; // por defecto
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Ejemplar</title>
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
        input, select, button {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Agregar Ejemplar</h2>

<form action="index.php?controlador=ejemplares&accion=crear" method="POST">
    <input type="hidden" name="id_libro" value="<?php echo htmlspecialchars($id_libro); ?>">

    <label>Estado:</label>
    <select name="estado" required>
        <option value="disponible" selected>Disponible</option>
        <option value="prestado">Prestado</option>
    </select>

    <button type="submit">Agregar Ejemplar</button>
    <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $id_libro; ?>">Cancelar</a>
</form>

</body>
</html>
