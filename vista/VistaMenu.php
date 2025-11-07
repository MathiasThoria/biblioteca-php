<?php 
// Saludamos al usuario por su nombre si está en la sesión
$nombreUsuario = $_SESSION['usuario']['nombre'] ?? 'Usuario';
?>

<?php include(__DIR__ . '/plantilla/header.php'); ?>

<style>
    /* Estilo para las tarjetas del dashboard */
    .dashboard-card {
        text-align: center; /* Centra el texto */
        padding: 2rem; /* Más espacio interno */
        transition: transform 0.2s ease, box-shadow 0.2s ease; /* Animación suave */
    }
    .dashboard-card:hover {
        transform: translateY(-5px); /* Se eleva un poco al pasar el mouse */
        box-shadow: var(--pico-shadow-color) 0px 8px 24px 0px; /* Sombra más pronunciada */
    }
    /* Estilo para el ícono SVG */
    .dashboard-card svg {
        width: 64px;
        height: 64px;
        stroke: var(--pico-primary); /* Color del ícono (azul por defecto) */
        margin-bottom: 1rem;
    }
    /* Título de la tarjeta */
    .dashboard-card h3 {
        margin-bottom: 0.5rem;
    }
    /* Descripción de la tarjeta */
    .dashboard-card p {
        color: var(--pico-h6-color); /* Un color más suave para la descripción */
    }
    /* Hacemos que toda la tarjeta sea un enlace */
    .dashboard-card a {
        text-decoration: none; /* Quitamos el subrayado del enlace */
        color: inherit; /* El enlace hereda el color del texto */
    }
    .dashboard-card a::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
    }
</style>

<h2 style="text-align: center; margin-bottom: 2rem;">¡Bienvenido, <?= htmlspecialchars($nombreUsuario) ?>!</h2>

<div class="grid">

    <article class="dashboard-card">
        <a href="index.php?controlador=libros&accion=listar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <h3>Gestión de Libros</h3>
            <p>Añadir, buscar y editar libros y ejemplares.</p>
        </a>
    </article>

    <article class="dashboard-card">
        <a href="index.php?controlador=usuarios&accion=listar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <h3>Gestión de Usuarios</h3>
            <p>Registrar y administrar los perfiles de los usuarios.</p>
        </a>
    </article>

    <article class="dashboard-card">
        <a href="index.php?controlador=prestamos&accion=listar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 16 16 12 12 8"></polyline>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            <h3>Gestión de Préstamos</h3>
            <p>Registrar préstamos y devoluciones pendientes.</p>
        </a>
    </article>

</div> <?php include(__DIR__ . '/plantilla/footer.php'); ?>