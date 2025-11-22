<?php
/**
 * Middleware para páginas que NO requieren autenticación (login/register)
 * Redirige al index si el usuario ya está logueado
 */

session_start();

// Si ya está logueado, redirigir al index
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: /index.php");
    exit;
}
