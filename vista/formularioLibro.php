<?php
// formulario_libro.php

// Si $libro viene del controlador, se usan sus valores; si no, se deja vacío
$titulo = isset($libro['titulo']) ? $libro['titulo'] : '';
$autor  = isset($libro['autor'])  ? $libro['autor']  : '';
$isbn   = isset($libro['isbn'])   ? $libro['isbn']   : '';
$id     = isset($libro['id'])     ? $libro['id']     : '';
$editorial = isset($libro['editorial']) ? $libro['editorial'] : '';
$accion = $id ? 'editar&id=' . $id : 'crear';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? "Editar Libro" : "Agregar Libro"; ?></title>
    <style>
        form {
            width: 400px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        button, a {
            margin-top: 15px;
            padding: 6px 12px;
            text-decoration: none;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;"><?php echo $id ? "Editar Libro" : "Agregar Libro"; ?></h2>




<form action="index.php?controlador=libros&accion=<?php echo $accion; ?>" method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>

    <label>Autor:</label>
    <input type="text" name="autor" value="<?php echo htmlspecialchars($autor); ?>" required>

    <label>ISBN:</label>
    <input type="text" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required>
    
    <label>Editorial:</label>
    <input type="text" name="editorial" value="<?php echo htmlspecialchars($editorial); ?>" required>

    <div style="margin-top:15px;">
        <button type="submit"><?php echo $id ? "Actualizar" : "Guardar"; ?></button>
        <a href="index.php?controlador=libros&accion=listar">Cancelar</a>
    </div>
</form>
<a href="index.php?controlador=libros&accion=listar">⬅ Volver a la lista</a>
</body>
</html>
