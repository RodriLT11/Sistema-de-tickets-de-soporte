<?php
// Middleware: no permitir acceso si ya está logueado
require_once __DIR__ . '/../middleware/guest.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="../css/auth/auth-common.css">
<link rel="stylesheet" href="../css/auth/login.css">

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

<div class="login-card">
    <h2>Iniciar Sesión</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="/handlers/auth/login_handler.php" method="POST">
        <label>Usuario o Email</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($_SESSION['old_usuario'] ?? '') ?>" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <div style="display: flex; align-items: center; margin-top: 10px;">
            <input type="checkbox" name="remember" id="remember" style="width: auto; margin-right: 8px;">
            <label for="remember" style="margin: 0; font-weight: normal; color: var(--text);">Recordarme</label>
        </div>

        <button type="submit">Entrar</button>
    </form>

    <p class="auth-link">
        ¿No tienes cuenta? <a href="register.php">Regístrate</a>
    </p>
</div>

<script src="../js/utils/toggle_theme.js"></script>

</body>
</html>
