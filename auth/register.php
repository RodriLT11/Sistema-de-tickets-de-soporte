<?php
session_start();

// Recuperar valores anteriores si existen
$old_username = $_SESSION['old_username'] ?? '';
$old_email = $_SESSION['old_email'] ?? '';

// Limpiar después de usarlos
unset($_SESSION['old_username'], $_SESSION['old_email']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="../css/auth/auth-common.css">
<link rel="stylesheet" href="../css/auth/register.css">
</head>

<body>

<!-- SWITCH CON ICONOS -->
<div class="switch-container">
    <input type="checkbox" id="themeSwitch" onchange="toggleTheme()">
    <label for="themeSwitch" class="switch">
        <span>🌙</span>
        <span>☀️</span>
    </label>
</div>

<div class="register-card">
    <h2>Registrarse</h2>

    <form action="../handlers/auth/register_handler.php" method="POST">
        <label>Nombre de usuario</label>
        <input type="text" name="username" value="<?= htmlspecialchars($old_username) ?>" required>

        <label>Correo electrónico</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old_email) ?>" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirm" required>

        <button type="submit">Registrarse</button>
    </form>

    <p class="auth-link">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </p>
</div>

<script src="../js/utils/toggle_theme.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/utils/alerts_sweetalert.js"></script>

<?php
if (isset($_SESSION['success'])) {
    echo "<script>showSuccess('{$_SESSION['success']}', '/auth/login.php');</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>showError('{$_SESSION['error']}');</script>";
    unset($_SESSION['error']);
}
?>

</body>
</html>
