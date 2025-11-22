<?php
/**
 * Cargador de variables de entorno desde archivo .env
 * Función simple para leer el archivo .env sin dependencias externas
 */

function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception("Archivo .env no encontrado en: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Separar clave=valor
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Remover comillas si existen
        $value = trim($value, '"\'');

        // Establecer variable de entorno
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}

/**
 * Obtener variable de entorno con valor por defecto
 */
function env($key, $default = null) {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// Cargar el archivo .env automáticamente
// Buscar el .env en la raíz del proyecto (subir hasta encontrarlo)
$envPath = __DIR__ . '/../.env';

// Si no lo encuentra, intentar desde la raíz absoluta
if (!file_exists($envPath)) {
    // Buscar la raíz del proyecto subiendo directorios
    $currentDir = __DIR__;
    $found = false;
    
    for ($i = 0; $i < 5; $i++) {
        $testPath = $currentDir . '/.env';
        if (file_exists($testPath)) {
            $envPath = $testPath;
            $found = true;
            break;
        }
        $currentDir = dirname($currentDir);
    }
}

if (file_exists($envPath)) {
    loadEnv($envPath);
}
