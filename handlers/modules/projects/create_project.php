<?php
require_once __DIR__ . '/../../../config/db.php';
session_start();

header('Content-Type: application/json');

try {

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || empty(trim($data['name']))) {
        echo json_encode([
            'success' => false,
            'message' => 'El nombre del proyecto es requerido'
        ]);
        exit;
    }
    
    $name = trim($data['name']);
    $description = trim($data['description'] ?? '');
    $userId = intval($_SESSION['user_id']);
    
    // Crear el proyecto
    $stmt = $conn->prepare("INSERT INTO projects (name, description, `deleted`) VALUES (?, ?, 0)");
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    
    $projectId = $conn->insert_id;
    
    // Asignar al usuario como administrador (role_id = 3)
    $roleId = 3; // administrador
    $stmtAssign = $conn->prepare("INSERT INTO project_users (user_id, project_id, role_id) VALUES (?, ?, ?)");
    $stmtAssign->bind_param("iii", $userId, $projectId, $roleId);
    $stmtAssign->execute();
    
    echo json_encode([
        'success' => true,
        'message' => 'Proyecto creado correctamente',
        'id' => $projectId
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear proyecto: ' . $e->getMessage()
    ]);
}
?>
