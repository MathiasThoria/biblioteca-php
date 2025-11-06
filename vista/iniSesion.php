<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir al login si no hay usuario
if (!isset($_SESSION['usuario'])) {
    header("Location: VistaLogin.php");
    exit();
}
?>
