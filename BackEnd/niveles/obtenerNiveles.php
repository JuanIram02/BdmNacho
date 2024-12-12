<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

// Obtener el id_curso desde los parámetros GET
$id_curso = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_curso <= 0) {
    echo json_encode(["status" => "error", "message" => "ID de curso inválido"]);
    exit;
}

// Llamar al procedimiento almacenado SpNivel para obtener los niveles del curso
$stmt = $mysqli->prepare("CALL SpNivel( NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_ALL')"); 
$stmt->bind_param("i", $id_curso);

$niveles = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    
    // Obtener todos los niveles
    while ($row = $result->fetch_assoc()) {
        $niveles[] = $row;
    }

    // Si se encuentran niveles, retornamos la respuesta exitosa
    if (!empty($niveles)) {
        echo json_encode(['status' => 'success', 'niveles' => $niveles]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontraron niveles para este curso']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al obtener los niveles']);
}

$stmt->close();
?>
