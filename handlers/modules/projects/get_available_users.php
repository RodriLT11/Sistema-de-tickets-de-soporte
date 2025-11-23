<?php
require_once __DIR__ . '/../../../config/db.php';
session_start();

header('Content-Type: application/json');

try {
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['project_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID del proyecto requerido'
        ]);
        exit;
    }
    
    $projectId = intval($data['project_id']);
    
    // Obtener todos los usuarios que no están asignados a este proyecto
    $stmt = $conn->prepare("
        SELECT id, username, email 
        FROM users 
        WHERE id NOT IN (
            SELECT user_id FROM project_users WHERE project_id = ?
        )
        ORDER BY username ASC
    ");
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    
    echo json_encode([
        'success' => true,
        'users' => $users
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener usuarios: ' . $e->getMessage()
    ]);
}
?>
