<?php
require_once __DIR__ . '/../../../config/db.php';

header('Content-Type: application/json');

try {
    
    $stmt = $conn->prepare("SELECT id, name, description, created_at FROM projects WHERE `deleted` = 0 ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $projects = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode([
        'success' => true,
        'projects' => $projects
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener proyectos: ' . $e->getMessage()
    ]);
}
?>
