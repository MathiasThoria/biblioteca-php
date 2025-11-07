<?php
// VistaPrestamos.php
// $prestamos viene del controlador
$filtro_estado = $_GET['filtro_estado'] ?? 'todos'; // Leemos el filtro desde $_GET
?>

<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    <h2 style="text-align:center;">Gestión de Préstamos</h2>
    
    <div class="grid">
        
        <div>
            <form action="index.php" method="GET" style="margin-bottom: 0;">
                <input type="hidden" name="controlador" value="prestamos">
                <input type="hidden" name="accion" value="listar">
                
                <fieldset role="group">
                    <label for="filtro_estado" style="margin-bottom: 0;">Mostrar:</label>
                    <select name="filtro_estado" id="filtro_estado">
                        <option value="todos" <?= ($filtro_estado=='todos') ? 'selected' : '' ?>>Todos</option>
                        <option value="pendientes" <?= ($filtro_estado=='pendientes') ? 'selected' : '' ?>>Pendientes</option>
                    </select>
                    <button type="submit">Aplicar</button>
                </fieldset>
            </form>
        </div>

        <div style="text-align: right;">
            <a href="index.php?controlador=prestamos&accion=crear" role="button">
                Ingresar Préstamo
            </a>
        </div>
    </div> <table>
        <thead>
            <tr>
                <th>Usuario (CI)</th>
                <th>Ejemplar (ID)</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Prevista</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prestamos)): ?>
                <?php foreach ($prestamos as $p): ?>
                    <?php
                    // Calcular estado (esta lógica ya la tenías y estaba perfecta)
                    $hoy = new DateTime();
                    $fecha_prevista = new DateTime($p['fecha_prevista_devolucion']);
                    
                    if ($p['estado_ejemplar'] === 'disponible') {
                        $estado = 'Devuelto';
                        $clase_estado = 'devuelto';
                    } else if ($fecha_prevista < $hoy) {
                        $estado = 'Vencido';
                        $clase_estado = 'vencido';
                    } else {
                        $estado = 'Pendiente';
                        $clase_estado = 'pendiente';
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($p['cedula']) ?></td>
                        <td><?= $p['id_ejemplar'] ?></td>                
                        <td><?= $p['fecha_prestamo'] ?></td>
                        <td><?= $p['fecha_prevista_devolucion'] ?></td>
                        <td><?= $p['fecha_devolucion'] ?? '...' ?></td>
                        
                        <td><mark class="<?= $clase_estado ?>"><?= $estado ?></mark></td>
                        
                        <td>
                            <?php if ($estado == 'Pendiente' || $estado == 'Vencido'): ?>
                                <a href="index.php?controlador=prestamos&accion=marcarDevuelto&id=<?= $p['id_prestamo'] ?>">Devolver</a> |
                            <?php endif; ?>
                            
                            <a href="index.php?controlador=prestamos&accion=eliminar&id=<?= $p['id_prestamo'] ?>"
                               onclick="return confirm('¿Seguro que querés eliminar este préstamo?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">No hay préstamos para mostrar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</article>
<style>
    mark.devuelto {
        background-color: var(--pico-color-green-150);
        color: var(--pico-color-green-700);
        padding: 2px 6px;
        border-radius: var(--pico-border-radius);
    }
    mark.pendiente {
        background-color: var(--pico-color-amber-150);
        color: var(--pico-color-amber-700);
        padding: 2px 6px;
        border-radius: var(--pico-border-radius);
    }
    mark.vencido {
        background-color: var(--pico-color-red-150);
        color: var(--pico-color-red-700);
        padding: 2px 6px;
        border-radius: var(--pico-border-radius);
    }
</style>


<?php include(__DIR__ . '/plantilla/footer.php'); ?>