<h2 style="text-align:center;">Gestión de Ejemplares</h2>

<?php if (isset($libro)): ?>
    <p style="text-align:center;">
        Ejemplares del libro: <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong> 
        (ID: <?php echo $libro['id']; ?>)
    </p>
<?php endif; ?>
<a href="index.php?controlador=prestamos&accion=listar">⬅ Volver a la lista Prestamos</a>
<a href="index.php?controlador=libros&accion=listar"><br>⬅ Volver a la lista Libros</a>
<a href="index.php?controlador=general"><br>⬅ Volver al Menu</a>
<div style="text-align:center; margin-bottom: 15px;">
    <a href="index.php?controlador=ejemplares&accion=crear&id_libro=<?php echo $libro['id']; ?>">
        Agregar Ejemplar
    </a>
</div>

<table border="1" style="width:60%; margin:0 auto; border-collapse:collapse;">
    <thead>
        <tr>
            <th>ID Ejemplar</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($ejemplares)): ?>
            <?php foreach ($ejemplares as $ej): ?>
                <tr>
                    <td><?php echo $ej['id_ejemplar']; ?></td>
                    <td><?php echo $ej['estado']; ?></td>
                    <td>
                        <a href="index.php?controlador=ejemplares&accion=editar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>">Editar</a>
                        <a href="index.php?controlador=ejemplares&accion=eliminar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>&id_libro=<?php echo $libro['id']; ?>" 
                        onclick="return confirm('¿Seguro que querés eliminar este ejemplar?');">Eliminar</a>    
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No hay ejemplares registrados</td></tr>
        <?php endif; ?>
    </tbody>
</table>
