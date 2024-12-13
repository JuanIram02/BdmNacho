<?php
header('Content-Type: application/json');
include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$id_curso = isset($_GET['id']) ? intval($_GET['id']) : 0;

session_start();
$id_estudiante = $_SESSION['id_usuario'];

$query = "CALL SpInscripcion(NULL, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_ESTUDIANTE_CURSO')";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('ii', $id_curso, $id_estudiante);

$stmt->execute();

$result = $stmt->get_result();
if ($result) {
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success", "exists" => true]);
    } else {
        echo json_encode(["status" => "success", "exists" => false]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta."]);
}

$stmt->close();
?>
