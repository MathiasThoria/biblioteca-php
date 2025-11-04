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

<h2 style="text-align:center;">Lista de Libros</h2>

<a href="formulario_libro.php">Agregar Nuevo Libro</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>ISBN</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>
                    <td><?php echo $libro['isbn']; ?></td>
                    <td>
                        <a href="index.php?accion=ver&id=<?php echo $libro['id']; ?>">Ver</a>
                        <a href="formulario_libro.php?accion=editar&id=<?php echo $libro['id']; ?>">Editar</a>
                        <a href="index.php?accion=eliminar&id=<?php echo $libro['id']; ?>" 
                           onclick="return confirm('¿Seguro que quieres eliminar este libro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">No hay libros registrados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

