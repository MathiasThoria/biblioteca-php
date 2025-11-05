<?php
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
