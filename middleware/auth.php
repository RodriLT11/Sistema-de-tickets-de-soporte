<?php
/**
 * Middleware para proteger páginas que requieren autenticación
 */

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    
    // Intentar login automático con cookie
    if (isset($_COOKIE['remember_token']) && isset($_COOKIE['user_id'])) {
        require_once __DIR__ . '/../config/db.php';
        
        $user_id = (int)$_COOKIE['user_id'];
        
        // Buscar usuario
        $stmt = $conn->prepare("SELECT id, username, email, status FROM users WHERE id = ? AND status = 'activo' LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Restaurar sesión
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            
            // Continuar en la página actual
            return;
        }
    }
    
    // Si no está logueado, redirigir al login
    $_SESSION['error'] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: /auth/login.php");
    exit;
}

// Opcional: Verificar timeout de sesión (ej: 2 horas)
$timeout = 2 * 60 * 60; // 2 horas en segundos
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['error'] = "Tu sesión ha expirado. Por favor, inicia sesión nuevamente.";
    header("Location: /auth/login.php");
    exit;
}

// Actualizar tiempo de actividad
$_SESSION['last_activity'] = time();
