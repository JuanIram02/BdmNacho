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

$stmt = $mysqli->prepare("CALL SpCurso( ?, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_BY_ID')");
$stmt->bind_param("i", $id_curso);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Convertir el avatar a base64 si está presente
        $imagenBlob = $row['imagen'] ?? '';
        $row['imagen'] = base64_encode($imagenBlob);
        echo json_encode(['status' => 'success', 'curso' => $row]);
    } else {
        echo json_encode(['error' => 'Curso no encontrado']);
    }
} else {
    echo json_encode(['error' => 'Error en el procedimiento almacenado']);
}
$stmt->close();

?>
