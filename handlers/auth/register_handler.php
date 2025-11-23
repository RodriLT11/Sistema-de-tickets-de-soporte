<?php
session_start();
require_once '../../config/db.php';
require_once '../../helpers/csrf.php';
require_once '../../helpers/avatar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['error'] = "Token de seguridad inválido. Intenta nuevamente.";
        header("Location: /auth/register.php");
        exit;
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Guardar valores anteriores
    $_SESSION['old_username'] = $username;
    $_SESSION['old_email'] = $email;

    // Validar contraseñas
    if ($password !== $password_confirm) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: /auth/register.php");
        exit;
    }

    // Validar si el email ya existe
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "El correo electrónico ya está registrado.";
        header("Location: /auth/register.php");
        exit;
    }

    // Hashear contraseña
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hashed);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id; // Obtener el ID del usuario recién creado
        
        // Generar y guardar el avatar
        try {
            assign_avatar_to_user($user_id, $username, $conn);
        } catch (Exception $e) {
            // Si falla el avatar, no afecta el registro
            error_log("Error al generar avatar: " . $e->getMessage());
        }
        
        unset($_SESSION['old_username'], $_SESSION['old_email']); // limpiar valores antiguos
        $_SESSION['success'] = "Registro completado con éxito.";
        header("Location: /auth/register.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al registrar el usuario: " . $stmt->error;
        header("Location: /auth/register.php");
        exit;
    }
}
