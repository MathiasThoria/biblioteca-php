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

