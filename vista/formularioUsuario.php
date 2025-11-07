<?php
// formularioUsuario.php
// (Este bloque PHP ya tiene las correcciones que hicimos antes)
$cedula = $usuario['cedula'] ?? '';
$nombre = $usuario['nombre'] ?? '';
$direccion = $usuario['direccion'] ?? '';
$contrasena = ''; // La contraseña no se muestra
$perfil = $usuario['perfil'] ?? 'usuario';
$accion = isset($usuario) ? 'editar&cedula=' . $cedula : 'crear';
?>

<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    <h2 style="text-align:center;">
        <?= isset($usuario) ? 'Editar Usuario' : 'Agregar Nuevo Usuario' ?>
    </h2>
    
    <form action="index.php?controlador=usuarios&accion=<?= $accion ?>" method="POST">
    
        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" id="cedula" value="<?= htmlspecialchars($cedula) ?>" 
               <?= isset($usuario) ? 'readonly' : 'required' ?>>
    
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
    
        <label for="direccion">Dirección:</labe>
        <input type="text" name="direccion" id="direccion" value="<?= htmlspecialchars($direccion) ?>" required>
    
        <label for="contrasena">Contraseña:</label>
        <input type="text" name="contrasena" id="contrasena" value="<?= htmlspecialchars($contrasena) ?>" 
               placeholder="<?= isset($usuario) ? 'Dejar vacío para no cambiar' : 'Requerido' ?>">
    
        <label for="perfil">Perfil:</label>
        <select name="perfil" id="perfil">
            <option value="usuario" <?= $perfil=='usuario' ? 'selected' : '' ?>>Usuario</option>
            <option value="administrador" <?= $perfil=='administrador' ? 'selected' : '' ?>>Administrador</option>
        </select>
    
        <fieldset>
            <button type="submit">
                <?= isset($usuario) ? 'Guardar Cambios' : 'Agregar Usuario' ?>
            </button>
            <a href="index.php?controlador=usuarios&accion=listar" role="button" class="contrast">Cancelar</a>
        </fieldset>
    
    </form>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>