<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$id_curso = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_curso <= 0) {
    echo json_encode(["status" => "error", "message" => "ID de curso inválido"]);
    exit;
}

$stmt = $mysqli->prepare("CALL SpMensaje(NULL, NULL, NULL, ?, NULL, NULL, 'SELECT_BY_COURSE')");
$stmt->bind_param("i", $id_curso);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $messages = [];
    
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    if (!empty($messages)) {
        echo json_encode(['status' => 'success', 'messages' => $messages]);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'No hay mensajes aun']);
    }
} else {
    echo json_encode(['error' => 'Error en el procedimiento almacenado']);
}

$stmt->close();
?>
