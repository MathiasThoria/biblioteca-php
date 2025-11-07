<?php
// formularioEjemplar.php

// Esta lógica staba correcta
$id_libro = $ejemplar['id_libro'] ?? $id_libro ?? '';
$estado   = $ejemplar['estado'] ?? 'disponible';
$accion   = isset($ejemplar) ? "editar&id_ejemplar=" . $ejemplar['id_ejemplar'] : "crear";
$titulo_pagina = isset($ejemplar) ? "Editar Ejemplar" : "Agregar Ejemplar";
?>

<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    <h2 style="text-align:center;"><?php echo $titulo_pagina; ?></h2>

    <form action="index.php?controlador=ejemplares&accion=<?php echo $accion; ?>" method="POST">
        <input type="hidden" name="id_libro" value="<?php echo htmlspecialchars($id_libro); ?>">

        <label>Estado:</label>
        <select name="estado" required>
            <option value="disponible" <?php echo $estado=='disponible' ? 'selected' : ''; ?>>Disponible</option>
            <option value="prestado" <?php echo $estado=='prestado' ? 'selected' : ''; ?>>Prestado</option>
        </select>

        <br>
        
        <fieldset>
            <button type="submit"><?php echo isset($ejemplar) ? "Actualizar" : "Agregar"; ?></button>
            <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $id_libro; ?>" role="button" class="contrast">Cancelar</a>
        </fieldset>
        
    </form>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>