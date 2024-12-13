<?php
header('Content-Type: application/json');
include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : NULL;
$end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : NULL;
$category = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : NULL; 

$progreso = ($_GET['completed'] ? '100' : NULL);
$active = ($_GET['active'] ? 'A' : NULL);

session_start();
$id_estudiante = $_SESSION['id_usuario'];

$query = "CALL SpInscripcion(NULL, ?, ?, ?, NULL, ?, ?, ?, NULL, 'VIEW_KARDEX')";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('iissss', $category, $id_estudiante, $start_date, $end_date, $progreso, $active);

$stmt->execute();

$result = $stmt->get_result();
if ($result) {
    $inscripciones = [];

    while ($row = $result->fetch_assoc()) {
        $inscripciones[] = [
            "curso_id" => $row["curso_id"],
            "nombre" => $row["titulo_curso"], // Título del curso
            "nombre_alumno" => $row["nombre_alumno"], // Título del curso
            "progreso" => $row["progreso_curso"],
            "fecha_inscripcion" => $row["fecha_inscripcion"],
            "ultimo_acceso" => $row["fecha_ultima"],
            "fecha_terminacion" => $row["fecha_terminacion"],
            "estado" => $row["estado_inscripcion"]
        ];
    }

    if (count($inscripciones) > 0) {
        echo json_encode(["status" => "success", "cursos" => $inscripciones]);
    } else {
        echo json_encode(["status" => "success", "cursos" => [], "message" => "No se encontraron resultados."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta."]);
}

$stmt->close();
?>
