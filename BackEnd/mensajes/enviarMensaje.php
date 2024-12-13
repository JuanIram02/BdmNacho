<?php
header('Content-Type: application/json');

include '../Connection.php';

session_start();

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$data = json_decode(file_get_contents('php://input'), true);

// Verificar y asignar las variables
$p_remitente_id = $_SESSION["id_usuario"];
$p_curso_id = isset($data['curso_id']) ? intval($data['curso_id']) : 0;
$p_contenido = isset($data['contenido']) && is_string($data['contenido']) ? trim($data['contenido']) : '';

if ($p_remitente_id <= 0 || $p_curso_id <= 0 || $p_contenido == "") {
    echo json_encode(["status" => "error", "message" => [$p_remitente_id, $p_curso_id, $_POST['contenido']]]);
    exit;
}

$stmt = $mysqli->prepare("CALL SpMensaje(NULL, ?, NULL, ?, ?, 1, 'INSERT')");
$stmt->bind_param("iis", $p_remitente_id, $p_curso_id, $p_contenido);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Mensaje insertado correctamente']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al insertar el mensaje']);
}

$stmt->close();
?>
