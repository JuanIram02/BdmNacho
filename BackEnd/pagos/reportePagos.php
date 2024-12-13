<?php
header('Content-Type: application/json');
include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : NULL;
$end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : NULL;

session_start();
$id_estudiante = $_SESSION['id_usuario'];

$query = "CALL SpInscripcion(NULL, NULL, NULL, ?, NULL, ?, NULL, NULL, NULL, 'VIEW_PAGOS')";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('ss', $start_date, $end_date);

$stmt->execute();

$result = $stmt->get_result();
if ($result) {
    $pagos = [];

    while ($row = $result->fetch_assoc()) {
        $pagos[] = [
            "nombre_alumno" => $row["nombre_alumno"],               
            "fecha_inscripcion" => $row["fecha_inscripcion"],       
            "nivel_avance" => $row["nivel_avance"],
            "precio_pagado" => $row["precio_pagado"],               
            "forma_pago" => $row["forma_pago"],                     
        ];
    }

    if (count($pagos) > 0) {
        echo json_encode(["status" => "success", "pagos" => $pagos]);
    } else {
        echo json_encode(["status" => "success", "pagos" => [], "message" => "No se encontraron resultados."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta."]);
}

$stmt->close();
?>
