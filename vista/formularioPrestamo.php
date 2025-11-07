<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    <h2 style="text-align:center;">Registrar nuevo préstamo</h2>

    <form action="index.php?controlador=prestamos&accion=crear" method="POST">
        <label for="cedula">Cédula del usuario:</label>
        <input type="number" name="cedula" id="cedula" placeholder="Ej: 52345678" required>

        <label for="id_ejemplar">ID del ejemplar:</label>
        <input type="number" name="id_ejemplar" id="id_ejemplar" placeholder="Ej: 15" required>

        <label for="fecha_prestamo">Fecha del préstamo:</label>
        <input type="date" name="fecha_prestamo" id="fecha_prestamo" value="<?= date('Y-m-d') ?>" required>

        <label for="fecha_prevista_devolucion">Fecha prevista de devolución:</label>
        <input type="date" name="fecha_prevista_devolucion" id="fecha_prevista_devolucion" required>

        <?php if (isset($error)): ?>
            <p style="color: var(--pico-color-red-600); font-weight: bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <br>
        
        <fieldset>
            <button type="submit">Guardar préstamo</button>
            <a href="index.php?controlador=prestamos&accion=listar" role="button" class="contrast">Volver a la lista</a>
        </fieldset>

    </form>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>