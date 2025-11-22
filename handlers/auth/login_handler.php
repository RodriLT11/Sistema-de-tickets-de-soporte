<?php
session_start();
require_once '../../config/db.php';
require_once '../../helpers/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['error'] = "Token de seguridad inválido. Intenta nuevamente.";
        header("Location: /auth/login.php");
        exit;
    }
    
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    // Buscar usuario por username o email
    $stmt = $conn->prepare("SELECT id, username, email, password, status FROM users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        $_SESSION['old_usuario'] = $usuario;
        header("Location: /auth/login.php");
        exit;
    }

    $user = $result->fetch_assoc();

    // Verificar si el usuario está activo
    if ($user['status'] !== 'activo') {
        $_SESSION['error'] = "Tu cuenta está inactiva. Contacta al administrador.";
        header("Location: /auth/login.php");
        exit;
    }

    // Verificar contraseña
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        $_SESSION['old_usuario'] = $usuario;
        header("Location: /auth/login.php");
        exit;
    }

    // Login exitoso - Regenerar ID de sesión por seguridad
    session_regenerate_id(true);

    // Guardar información en sesión
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();

    // Si seleccionó "Recordarme", crear cookie
    if ($remember) {
        // Generar token único
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 días

        // Guardar token en la base de datos (necesitarás crear esta tabla)
        // Por ahora, usamos cookie simple
        setcookie('remember_token', $token, $expiry, '/', '', true, true);
        setcookie('user_id', $user['id'], $expiry, '/', '', true, true);
    }

    // Limpiar valores antiguos
    unset($_SESSION['old_usuario'], $_SESSION['error']);

    // Redirigir al dashboard
    header("Location: /index.php");
    exit;

} else {
    // Si acceden directamente al handler, redirigir al login
    header("Location: /auth/login.php");
    exit;
}