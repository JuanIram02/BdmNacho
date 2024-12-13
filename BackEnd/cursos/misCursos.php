<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

session_start();

$id_estudiante = $_SESSION['id_usuario'];

$query = $mysqli->prepare("CALL SpInscripcion(NULL, NULL, ?, NULL, NULL, NULL, NULL, NULL, NULL, 'VIEW_BY_ESTUDIANTE')");
$query->bind_param('i', $id_estudiante);

if ($query->execute()) {
    $result = $query->get_result();
    $cursos = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $cursos[] = [
            "id_curso" => $row["curso_id"],
            "titulo" => $row["titulo"],
            "descripcion" => $row["descripcion"],
            "precio" => $row["costo_curso"],
            "progreso" => $row["progreso_curso"],
            "fecha_inscripcion" => $row["fecha_inscripcion"],
            "precio_pagado" => $row["precio_pagado"],
            "imagen" => base64_encode($row["imagen"])
        ];
    }

    echo json_encode(["status" => "success", "cursos" => $cursos]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron obtener los cursos."]);
}
?>
