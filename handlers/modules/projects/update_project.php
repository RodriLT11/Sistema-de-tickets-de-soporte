<?php
require_once __DIR__ . '/../../../config/db.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id']) || !isset($data['name'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }
    
    $id = intval($data['id']);
    $name = trim($data['name']);
    $description = trim($data['description'] ?? '');
    
    // Primero verificar que el proyecto existe
    $checkStmt = $conn->prepare("SELECT id FROM projects WHERE id = ? AND `deleted` = 0");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Proyecto no encontrado'
        ]);
        exit;
    }
    
    // Actualizar el proyecto
    $stmt = $conn->prepare("UPDATE projects SET name = ?, description = ? WHERE id = ? AND `deleted` = 0");
    $stmt->bind_param("ssi", $name, $description, $id);
    $stmt->execute();
    
    echo json_encode([
        'success' => true,
        'message' => 'Proyecto actualizado correctamente'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar proyecto: ' . $e->getMessage()
    ]);
}
?>
