<?php
// Configuración de la base de datos
$host = "localhost";      // o el host de tu servidor
$dbname = ""; // nombre de la base de datos
$user = "";           // usuario MySQL
$password = ""; // contraseña MySQL

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Opcional: configurar charset
$conn->set_charset("utf8");
?>
