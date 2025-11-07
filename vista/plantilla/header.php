<!DOCTYPE html>
<html lang="es" data-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPS Library System</title>
    
    <link rel="icon" type="image/png" href="https://image.prntscr.com/image/MB-d_91_SJSfhp4zXbvD0g.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    
    <style>
        /* ======== INICIO DE LA CORRECCIÓN DE SOLAPAMIENTO ======== */
        /*
         * 1. Quitamos el padding del body
         * 2. Lo aplicamos al <main> (el contenedor principal)
         * para empujar el contenido hacia abajo.
         */
        body {
            /* padding-top: 70px;  <-- Quitamos esto */
        }
        main.container {
            max-width: 960px; 
            padding-bottom: 40px;
            padding-top: 80px; /* <-- Agregamos esto (80px para estar seguros) */
        }
        /* ======== FIN DE LA CORRECCIÓN ======== */
        
        nav.container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background-color: var(--card-background-color);
            box-shadow: var(--card-shadow);
            
            /* Mejoramos la alineación de la navbar */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        /* Estilos para el nuevo logo y marca */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem; /* Espacio entre el logo y el texto */
            font-weight: bold;
            font-size: 1.1rem;
            text-decoration: none;
            color: var(--pico-h1-color);
        }
        .navbar-brand img {
            width: 40px; /* Tamaño del logo en la barra */
            height: 40px;
            border-radius: 4px;
        }
        
        /* Ocultamos los <ul> de Pico para un mejor control */
        nav ul {
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1rem; /* Espacio entre enlaces */
            align-items: center;
        }
        nav li {
            list-style: none;
            padding: 0;
            margin: 0;
        }

    </style>
</head>
<body>

    <nav class="container">
        
        <ul>
            <li>
                <a href="index.php?controlador=general&accion=inicio" class="navbar-brand">
                    <img src="https://image.prntscr.com/image/MB-d_91_SJSfhp4zXbvD0g.png" alt="Logo">
                    <span>SPS Library System</span>
                </a>
            </li>
            <li>
                <a href="index.php?controlador=general&accion=inicio" class="contrast" style="margin-left: 1rem;">
                    Inicio
                </a>
            </li>
        </ul>
        
        <ul>
            <li><a href="index.php?controlador=libros&accion=listar">Libros</a></li>
            <li><a href="index.php?controlador=usuarios&accion=listar">Usuarios</a></li>
            <li><a href="index.php?controlador=prestamos&accion=listar">Préstamos</a></li>
            <li><a href="index.php?controlador=usuarios&accion=logout" role="button" class="secondary">Cerrar Sesión</a></li>
        </ul>

    </nav>
    <main class="container"> ```

