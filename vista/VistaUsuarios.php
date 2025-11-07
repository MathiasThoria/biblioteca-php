<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    <h2 style="text-align:center;">Usuarios</h2>

    <form action="index.php" method="GET">
        <input type="hidden" name="controlador" value="usuarios">
        <input type="hidden" name="accion" value="listar">
        
        <input type="search" name="busqueda" placeholder="Buscar por cédula o nombre..." 
               value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
    </form>
    <div style="text-align:center; margin-bottom: 20px;">
        <a href="index.php?controlador=usuarios&accion=crear" role="button">Agregar Usuario</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['cedula']) ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['direccion']) ?></td>
                        <td>
                            <a href="index.php?controlador=usuarios&accion=ver&cedula=<?= $u['cedula'] ?>">Ver</a> |
                            <a href="index.php?controlador=usuarios&accion=editar&cedula=<?= $u['cedula'] ?>">Editar</a> |
                            <a href="index.php?controlador=usuarios&accion=eliminar&cedula=<?= $u['cedula'] ?>"
                               onclick="return confirm('¿Seguro que querés eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No hay usuarios para mostrar (o no se encontraron coincidencias).</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>