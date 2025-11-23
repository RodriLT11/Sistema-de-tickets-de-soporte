<?php
require_once __DIR__ . '/../../../config/db.php';
session_start();

header('Content-Type: application/json');

try {
    
    $userId = intval($_SESSION['user_id']);
    
    // Obtener proyectos donde el usuario está asignado y no están eliminados
    // Incluir el role_id del usuario en cada proyecto
    $stmt = $conn->prepare("
        SELECT p.id, p.name, p.description, p.created_at, pu.role_id
        FROM projects p
        INNER JOIN project_users pu ON p.id = pu.project_id
        WHERE pu.user_id = ? AND p.`deleted` = 0
        ORDER BY p.created_at DESC
    ");
    $stmt->bind_param("i", $userId);
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
