<?php include(__DIR__ . '/plantilla/header.php'); ?>

<article>

    
 <h2 style="text-align:center;">Gestión de Libros</h2>

    <form action="index.php" method="GET">
        <input type="hidden" name="controlador" value="libros">
        <input type="hidden" name="accion" value="listar">
        
        <input type="search" name="busqueda" placeholder="Buscar por título o autor..." 
               value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
        </form>
    <?php if (isset($_SESSION['usuario']['perfil']) && $_SESSION['usuario']['perfil'] === 'administrador'): ?>
        <div style="text-align:center; margin-bottom: 20px;">
            <a href="index.php?controlador=libros&accion=crear" role="button">Agregar Libro</a>        
        </div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Id</th>            
                <th>ISBN</th>
                <th>Título</th>
                <th>Autor</th>            
                <th>Editorial</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?php echo $libro['id']; ?></td>                    
                        <td><?php echo $libro['isbn']; ?></td>
                        <td><?php echo $libro['titulo']; ?></td>
                        <td><?php echo $libro['autor']; ?></td>                    
                        <td><?php echo $libro['editorial']; ?></td>
                        <td>
                            <a href="index.php?controlador=ejemplares&accion=listar&id_libro=<?php echo $libro['id']; ?>">Ver Ejemplares</a>
                            
                            <?php if (isset($_SESSION['usuario']['perfil']) && $_SESSION['usuario']['perfil'] === 'administrador'): ?>
                                | <a href="index.php?controlador=libros&accion=editar&id=<?php echo $libro['id']; ?>">Editar</a>
                                | <a href="index.php?controlador=libros&accion=eliminar&id=<?php echo $libro['id']; ?>"
                                    onclick="return confirm('¿Seguro que quieres eliminar este libro?')">Eliminar</a>
                            <?php endif; ?>                  
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No hay libros registrados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</article>
<?php include(__DIR__ . '/plantilla/footer.php'); ?>