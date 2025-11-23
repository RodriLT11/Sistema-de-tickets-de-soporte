<?php
require_once __DIR__ . '/../../../config/db.php';
session_start();

header('Content-Type: application/json');

try {
    // Recibir los datos desde la solicitud JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['project_id']) || !isset($data['user_id']) || !isset($data['role_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }

    $projectId = intval($data['project_id']);
    $userId = intval($data['user_id']);
    $roleId = intval($data['role_id']);

    // Verificar que el proyecto existe y no está eliminado
    $checkProjectStmt = $conn->prepare("SELECT name FROM projects WHERE id = ? AND deleted = 0");
    $checkProjectStmt->bind_param("i", $projectId);
    $checkProjectStmt->execute();
    $checkProjectResult = $checkProjectStmt->get_result();

    if ($checkProjectResult->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Proyecto no encontrado o eliminado'
        ]);
        exit;
    }

    // Verificar que el usuario existe
    $checkUserStmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $checkUserStmt->bind_param("i", $userId);
    $checkUserStmt->execute();
    $checkUserResult = $checkUserStmt->get_result();

    if ($checkUserResult->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
        exit;
    }

    // Verificar que el usuario no esté ya asignado al proyecto
    $checkAssignStmt = $conn->prepare("SELECT * FROM project_users WHERE user_id = ? AND project_id = ?");
    $checkAssignStmt->bind_param("ii", $userId, $projectId);
    $checkAssignStmt->execute();
    $checkAssignResult = $checkAssignStmt->get_result();

    if ($checkAssignResult->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Este usuario ya está asignado al proyecto'
        ]);
        exit;
    }

    // Agregar el usuario al proyecto
    $stmt = $conn->prepare("INSERT INTO project_users (user_id, project_id, role_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $projectId, $roleId);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Usuario agregado al proyecto correctamente'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al agregar usuario: ' . $e->getMessage()
    ]);
}
?>
