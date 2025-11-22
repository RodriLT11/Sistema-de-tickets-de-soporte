<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
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

    <form action="register_process.php" method="POST">
        <label>Usuario</label>
        <input type="text" name="usuario" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <p class="auth-link">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </p>
</div>

<script src="../js/buttons/toggle_theme.js"></script>

</body>
</html>
