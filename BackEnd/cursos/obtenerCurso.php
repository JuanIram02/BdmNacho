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

$query = "CALL SpCurso($id_curso, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_BY_ID')";

$result = mysqli_query($mysqli, $query);

if ($result) {
    $curso = mysqli_fetch_assoc($result);

    if ($curso) {
        echo json_encode(["status" => "success", "curso" => $curso]);
    } else {
        echo json_encode(["status" => "error", "message" => "Curso no encontrado"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta"]);
}
?>
