<?php
include '../Connection.php';

session_start();
date_default_timezone_set('America/Mexico_City');

header('Content-Type: application/json');

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode(["status" => "error", "message" => "No hay sesión activa"]);
    exit();
}

$estudiante_id = $_SESSION["id_usuario"];

$idCurso = $_POST["idCurso"] ?? null;
$costo = $_POST["costo"] ?? null;
$forma_pago = $_POST["forma_pago"] ?? null;

if (!$idCurso || !$costo || !$forma_pago) {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
    exit();
}

try {
    $database = new Database("localhost", "curso", "root", "");
    $database->connect();
    $mysqli = $database->getConnection();

    $query = "CALL SpPago(NULL, $idCurso, $estudiante_id, $costo, '$forma_pago', NOW(), 'INSERT')";
    
    if ($mysqli->query($query)) {
        echo json_encode(["status" => "success", "message" => "Pago procesado correctamente"]);
    } else {
        throw new Exception($mysqli->error);
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    
    if (str_contains($errorMsg, 'Ya existe un pago registrado')) {
        echo json_encode(["status" => "error", "message" => "Este curso ya es tuyo."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al procesar el pago.", "details" => $errorMsg]);
    }
}
?>
