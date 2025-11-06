<?php
// formularioUsuario.php

$cedula = $usuario['cedula'] ?? '';
$nombre = $usuario['nombre'] ?? '';
$apellido = $usuario['direccion'] ?? '';
$contrasena = $usuario['contrasena'] ?? '';
$perfil = $usuario['perfil'] ?? 'usuario';

$accion = isset($usuario) ? 'editar' : 'crear';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= isset($usuario) ? 'Editar Usuario' : 'Agregar Usuario' ?></title>
    <style>
        form { width: 320px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input, select, button { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
        button { cursor: pointer; }
        a { display: inline-block; margin-top: 10px; text-align: center; width: 100%; }
    </style>
</head>
<body>

<h2 style="text-align:center;">
    <?= isset($usuario) ? 'Editar Usuario' : 'Agregar Nuevo Usuario' ?>
</h2>

<form action="index.php?controlador=usuarios&accion=<?= $accion ?>" method="POST">
    <label for="cedula">Cédula:</label>
    <input type="text" name="cedula" id="cedula" value="<?= htmlspecialchars($cedula) ?>" 
           <?= isset($usuario) ? 'readonly' : 'required' ?>>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="direccion" id="direccion" value="<?= htmlspecialchars($apellido) ?>" required>

    <label for="contrasena">Contraseña:</label>
    
    <input type="text" name="contrasena" id="contrasena" value="<?= htmlspecialchars($contrasena) ?>" 
           <?= isset($usuario) ? '' : 'required' ?>>

    <label for="perfil">Perfil:</label>
    <select name="perfil" id="perfil">
        <option value="usuario" <?= $perfil=='usuario' ? 'selected' : '' ?>>Usuario</option>
        <option value="administrador" <?= $perfil=='administrador' ? 'selected' : '' ?>>Administrador</option>
    </select>

    <button type="submit">
        <?= isset($usuario) ? 'Guardar Cambios' : 'Agregar Usuario' ?>
    </button>

    <a href="index.php?controlador=usuarios&accion=listar">Cancelar</a>
</form>

<a href="index.php?controlador=usuarios&accion=listar">⬅ Volver a la lista</a>
</body>
</html>
