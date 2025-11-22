<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
    :root {
        --bg: #f2f2f2;
        --card-bg: #ffffff;
        --text: #222;
        --primary: #4a6cf7;
    }

    body.dark {
        --bg: #121212;
        --card-bg: #1f1f1f;
        --text: #e6e6e6;
        --primary: #7b9cff;
    }

    body {
        background: var(--bg);
        font-family: Arial, sans-serif;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        transition: 0.3s ease;
    }

    .login-card {
        background: var(--card-bg);
        padding: 40px;
        width: 350px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        transition: 0.3s ease;
    }

    h2 {
        color: var(--text);
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        color: var(--text);
        font-weight: bold;
        display: block;
        margin-top: 15px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background: var(--card-bg);
        color: var(--text);
        transition: 0.3s;
    }

    input:focus {
        border-color: var(--primary);
        outline: none;
    }

    button {
        width: 100%;
        margin-top: 20px;
        padding: 12px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    button:hover {
        opacity: 0.9;
    }

    /* SWITCH CON ICONOS 🌙☀️ */
    .switch-container {
        position: absolute;
        top: 20px;
        left: 20px;
    }

    .switch-container input {
        display: none;
    }

    .switch {
        width: 70px;
        height: 32px;
        background: #ccc;
        border-radius: 30px;
        display: flex;
        align-items: center;
        padding: 0 6px;
        justify-content: space-between;
        position: relative;
        cursor: pointer;
        font-size: 16px;
        color: white;
        transition: 0.3s;
    }

    /* Círculo deslizante */
    .switch::after {
        content: "";
        width: 28px;
        height: 28px;
        background: white;
        position: absolute;
        top: 2px;
        left: 2px;
        border-radius: 50%;
        transition: 0.3s;
    }

    /* Iconos */
    .switch span {
        z-index: 2;
    }

    /* Activado */
    #themeSwitch:checked + .switch {
        background: var(--primary);
    }

    #themeSwitch:checked + .switch::after {
        transform: translateX(48px);
    }

</style>
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

<div class="login-card">
    <h2>Iniciar Sesión</h2>

    <form action="validar_login.php" method="POST">
        <label>Usuario</label>
        <input type="text" name="usuario" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>
</div>

<script>
function toggleTheme() {
    document.body.classList.toggle("dark");
}
</script>

</body>
</html>
