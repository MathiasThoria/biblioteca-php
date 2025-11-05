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
