<?php
// VistaPrestamos.php

$filtro_estado = $_GET['filtro_estado'] ?? 'todos';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Préstamos</title>
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
        form {
            text-align: center;
            margin-top: 20px;
        }
        select, button {
            padding: 5px 10px;
            margin-left: 5px;
        }
        .vencido { color: red; font-weight: bold; }
        .pendiente { color: orange; font-weight: bold; }
        .devuelto { color: green; font-weight: bold; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Gestión de Préstamos</h2>
<a href="index.php?controlador=general">⬅ Volver al Menu</a>

<!-- Filtro de préstamos -->
<form action="index.php" method="GET">
    <input type="hidden" name="controlador" value="prestamos">
    <input type="hidden" name="accion" value="listar">

    <label>Mostrar:</label>
    <select name="filtro_estado">
        <option value="todos" <?= ($filtro_estado == 'todos') ? 'selected' : '' ?>>Todos</option>
        <option value="Pendiente" <?= ($filtro_estado == 'Pendiente') ? 'selected' : '' ?>>Pendientes</option>
    </select>
    <button type="submit">Aplicar</button>
</form>

<!-- Botón para nuevo préstamo -->
<a href="index.php?controlador=prestamos&accion=crear">
    Ingresar Préstamo
</a>
<table>
    <tr>
        <th>Usuario (CI)</th>
        <th>Ejemplar (ID)</th>
        <th>Fecha Préstamo</th>
        <th>Fecha Prevista Devolución</th>
        <th>Fecha Devolución</th>
        <th>Estado Préstamo</th>
        <th>Acciones</th>
    </tr>

    <?php if (!empty($prestamos)): ?>
        <?php foreach ($prestamos as $p): ?>
            <?php
            // Calcular estado
            $hoy = new DateTime();
            $fecha_prevista = new DateTime($p['fecha_prevista_devolucion']);
            $fecha_devuelto = !empty($p['fecha_devolucion']) ? new DateTime($p['fecha_devolucion']) : null;

            if (isset($fecha_devuelto)) {
                $estadoMostrar = 'Devuelto';
            }else{
                if($fecha_prevista < $hoy) {
                    $estadoMostrar = 'Vencido';
                }
                if($fecha_prevista >= $hoy){
                    $estadoMostrar = 'Pendiente';
                }
            }
            if($filtro_estado == 'todos' || $filtro_estado == $estadoMostrar):
            ?>
            <tr>
                <td><?= htmlspecialchars($p['cedula']) ?></td>
                <td><?= $p['id_ejemplar'] ?></td>                
                <td><?= $p['fecha_prestamo'] ?></td>
                <td><?= $p['fecha_prevista_devolucion'] ?></td>
                <td><?= $p['fecha_devolucion'] ?? '-' ?></td>
                <td class="<?= $p['estado_ejemplar'] ?>">
                <?= $estadoMostrar ?></td>
                <td>
                    <?php if ($estadoMostrar == 'Pendiente' || $estadoMostrar == 'Vencido'): ?>
                        <a href="index.php?controlador=prestamos&accion=marcarDevuelto&id=<?= $p['id_prestamo'] ?>">Devolver</a>
                    <?php endif; ?>                    
                    <a href="index.php?controlador=prestamos&accion=eliminar&id=<?= $p['id_prestamo'] ?>"
                       onclick="return confirm('¿Seguro que querés eliminar este préstamo?');">Eliminar</a>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="8">No hay préstamos para mostrar.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
