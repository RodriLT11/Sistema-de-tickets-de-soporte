<?php
// Cargar variables de entorno
require_once __DIR__ . '/env.php';

try {
    // Verificar que el .env se cargó correctamente
    if (!isset($_ENV['DB_HOST'])) {
        throw new Exception("Archivo .env no cargado. Verifique que existe en la raíz del proyecto.");
    }
    
    // Configuración de la base de datos desde .env
    $host = env('DB_HOST', 'localhost');
    $dbname = env('DB_NAME', 'support_system');
    $user = env('DB_USER', 'root');
    $password = env('DB_PASSWORD', '');
    $charset = env('DB_CHARSET', 'utf8mb4');

    // Crear conexión
    $conn = new mysqli($host, $user, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Configurar charset
    if (!$conn->set_charset($charset)) {
        throw new Exception("Error al configurar charset: " . $conn->error);
    }

} catch (Exception $e) {
    // Log del error (puedes agregar logging a archivo aquí)
    error_log("Database Error: " . $e->getMessage());
    error_log("Directorio Actual: " . __DIR__);
    error_log("Buscando .env: " . __DIR__ . '/../.env');
    error_log("Existe .env : " . (file_exists(__DIR__ . '/../.env') ? 'SI' : 'NO'));
    
    // Mostrar mensaje según el entorno
    if (env('APP_DEBUG', true)) {
        die("Error de base de datos: " . $e->getMessage() . "<br>Directorio: " . __DIR__);
    } else {
        die("Error al conectar con la base de datos. Por favor, contacte al administrador.");
    }
}
?>
