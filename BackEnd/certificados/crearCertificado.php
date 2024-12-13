<?php
// Establecer el tipo de contenido a JSON
header('Content-Type: application/json');

include '../Connection.php';

session_start();

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$id_estudiante = $_SESSION['id_usuario'];
$p_curso_id = isset($_POST['idCurso']) ? intval($_POST['idCurso']) : 0;

if ($id_estudiante <= 0 || $p_curso_id <= 0) {
    echo json_encode(["status" => "error", "message" => $p_curso_id]);
    exit;
}

try{
    $stmt = $mysqli->prepare("CALL SpCertificado(NULL, ?, ?, NULL, NULL, NULL, NULL, 'INSERT')");

    $stmt->bind_param("ii", $id_estudiante, $p_curso_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Certificado creado correctamente']);
    } else {
        throw new Exception($mysqli->error);
    }

}
catch (Exception $e) {
    $errorMsg = $e->getMessage();
    
    if (str_contains($errorMsg, 'Ya existe un certificado.')) {
        echo json_encode(["status" => "succes", "message" => "Curso ya terminado."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al crear el certificado.", "details" => $errorMsg]);
    }
}


$stmt->close();
?>
