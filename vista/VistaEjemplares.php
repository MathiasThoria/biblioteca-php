<?php include(__DIR__ . '/plantilla/header.php'); ?>

<style>
    .action-icon {
        display: inline-block;
        vertical-align: middle;
        width: 1.1rem;
        height: 1.1rem;
        margin-right: 4px;
        stroke-width: 2.5;
    }
    .icon-edit { stroke: var(--pico-color-amber-500); }
    .icon-delete { stroke: var(--pico-color-red-600); }
    
    /* Estilos para las "marcas" de estado */
    mark.disponible {
        background-color: var(--pico-color-green-150);
        color: var(--pico-color-green-700);
        padding: 2px 6px;
        border-radius: var(--pico-border-radius);
    }
    mark.prestado {
        background-color: var(--pico-color-amber-150);
        color: var(--pico-color-amber-700);
        padding: 2px 6px;
        border-radius: var(--pico-border-radius);
    }
</style>

<article>

    <h2 style="text-align:center;">Gestión de Ejemplares</h2>

    <?php if (isset($libro)): ?>
        <p style="text-align:center;">
            Ejemplares del libro: <strong><?php echo htmlspecialchars($libro['titulo']); ?></strong> 
            (ID: <?php echo $libro['id']; ?>)
        </p>
    <?php endif; ?>
    
    <div style="text-align:center; margin-bottom: 15px;">
        <a href="index.php?controlador=ejemplares&accion=crear&id_libro=<?php echo $libro['id']; ?>" role="button">
            Agregar Ejemplar
        </a>
    </div>

    <table>
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
                        <td>
                            <?php if($ej['estado'] == 'disponible'): ?>
                                <mark class="disponible">Disponible</mark>
                            <?php else: ?>
                                <mark class="prestado">Prestado</mark>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?controlador=ejemplares&accion=editar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>" title="Editar">
                                <svg class="action-icon icon-edit" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                Editar
                            </a>
                            
                            <a href="index.php?controlador=ejemplares&accion=eliminar&id_ejemplar=<?php echo $ej['id_ejemplar']; ?>&id_libro=<?php echo $libro['id']; ?>" 
                               onclick="return confirm('¿Seguro que querés eliminar este ejemplar?');" title="Eliminar">
                                <svg class="action-icon icon-delete" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                Eliminar
                            </a>    
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" style="text-align:center;">No hay ejemplares registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>