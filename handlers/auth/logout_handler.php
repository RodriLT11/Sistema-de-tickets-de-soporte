<?php
session_start();

// Destruir sesión
session_unset();
session_destroy();

// Eliminar cookies
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
}
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/', '', true, true);
}

// Mensaje de éxito
session_start();
$_SESSION['success'] = "Sesión cerrada exitosamente.";

// Redirigir al login
header("Location: /auth/login.php");
exit;
