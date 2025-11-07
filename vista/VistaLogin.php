<!DOCTYPE html>
<html lang="es" data-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
    <link rel="icon" type="image/png" href="https://image.prntscr.com/image/MB-d_91_SJSfhp4zXbvD0g.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    
    <style>
        
        main.container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 0; /* Quitamos el padding extra del container */
        }
        body {
             background-color: var(--pico-page-background-color);
        }
        /* La "tarjeta" del formulario */
        article {
            width: 400px; 
            padding: 2rem;
        }
        /* Contenedor para el logo y el slogan */
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            max-width: 150px; /* Ajusta el tamaño del logo */
            margin-bottom: 1rem;
            border-radius: 8px; /* Pequeño borde redondeado para el logo */
        }
        .logo-container p {
            font-size: 1.1rem;
            font-style: italic;
            color: var(--pico-h6-color); /* Color de texto secundario */
        }
    </style>
</head>
<body>

    <main class="container">
        <article>
            
            <div class="logo-container">
                <img src="https://image.prntscr.com/image/MB-d_91_SJSfhp4zXbvD0g.png" alt="Logo Biblioteca">
                <p>La puerta al conocimiento.</p>
            </div>
    
            <form action="index.php?controlador=usuarios&accion=validar" method="POST">
                
                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" id="cedula" required>
        
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
        
                <?php if (isset($error)): ?>
                    <p style="color: var(--pico-color-red-600);"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
        
                <button type="submit">Ingresar</button>
            </form>
    
        </article>
    </main>

</body>
</html>