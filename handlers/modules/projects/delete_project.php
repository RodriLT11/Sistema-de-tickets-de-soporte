<?php
require_once __DIR__ . '/../../../config/db.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID del proyecto no especificado'
        ]);
        exit;
    }
    
    $id = intval($data['id']);
    
    // Borrado lógico: actualizar delete = 1
    $stmt = $conn->prepare("UPDATE projects SET `deleted` = 1 WHERE id = ? AND `deleted` = 0");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Proyecto eliminado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Proyecto no encontrado'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar proyecto: ' . $e->getMessage()
    ]);
}
?>
