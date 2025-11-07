<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>
    
    <h2 style="text-align:center;">Detalle del Usuario</h2>

    <?php if (isset($usuario) && $usuario): ?>
        
        <div class="grid">
            <div>
                <h5 style="margin-bottom: 0.5rem;">Cédula:</h5>
                <p><?= htmlspecialchars($usuario['cedula']) ?></p>
            </div>
            <div>
                <h5 style="margin-bottom: 0.5rem;">Nombre:</h5>
                <p><?= htmlspecialchars($usuario['nombre']) ?></p>
            </div>
        </div>
        
        <h5 style="margin-bottom: 0.5rem;">Dirección:</h5>
        <p><?= htmlspecialchars($usuario['direccion']) ?></p>

        <h5 style="margin-bottom: 0.5rem;">Perfil:</h5>
        <p style="text-transform: capitalize;"><?= htmlspecialchars($usuario['perfil']) ?></p>

    <?php else: ?>
        <p>El usuario no fue encontrado.</p>
    <?php endif; ?>

    <footer style="text-align: center;">
        <a href="index.php?controlador=usuarios&accion=listar" role="button" class="contrast">Volver a la lista</a>
    </footer>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>