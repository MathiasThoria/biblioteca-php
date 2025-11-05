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

<h2 style="text-align:center;">Gestión de Libros</h2>

<?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'administrador'): ?>
    <div style="text-align:center; margin-bottom: 20px;">
        <a href="index.php?controlador=libros&accion=crear">Agregar Libro</a>        
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Id</th>            
            <th>ISBN</th>
            <th>Título</th>
            <th>Autor</th>            
            <th>Editorial</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>                    
                    <td><?php echo $libro['isbn']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>                    
                    <td><?php echo $libro['editorial']; ?></td>
                    <td>
                        <a href="index.php?controlador=libros&accion=ver&id=<?php echo $libro['id']; ?>">Ver</a>     
                        <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'administrador'): ?>
                            <a href="index.php?controlador=libros&accion=editar&id=<?php echo $libro['id']; ?>">Editar</a>
                            <a href="index.php?controlador=libros&accion=eliminar&id=<?php echo $libro['id']; ?>"
                                onclick="return confirm('¿Seguro que quieres eliminar este libro?')">Eliminar</a>
                            <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $libro['id']; ?>">Ejemplares</a>
                        <?php endif; ?>                  
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">No hay libros registrados</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
