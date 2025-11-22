<?php
// Proteger la página - requiere autenticación
require_once __DIR__ . '/middleware/auth.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/css/auth/auth-common.css">
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <!-- SWITCH CON ICONOS -->
    <div class="switch-container">
        <input type="checkbox" id="themeSwitch">
        <label for="themeSwitch" class="switch">
            <span>🌙</span>
            <span>☀️</span>
        </label>
    </div>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>
        <a href="/handlers/auth/logout_handler.php" class="logout-btn">Cerrar Sesión</a>
    </div>

    <script src="/js/utils/toggle_theme.js"></script>
</body>
</html>