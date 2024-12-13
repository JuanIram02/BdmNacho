<?php
header('Content-Type: application/json');
include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : NULL;
$end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : NULL;
$category = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : NULL; 

$active = ($_GET['active'] ? 'A' : NULL);

session_start();
$id_estudiante = $_SESSION['id_usuario'];

$query = "CALL SpInscripcion(NULL, ?, ?, ?, NULL, ?, NULL, ?, NULL, 'VIEW_VENTAS')";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('iisss', $category, $id_estudiante, $start_date, $end_date, $active);

$stmt->execute();

$result = $stmt->get_result();
if ($result) {
    $ventas = [];

    while ($row = $result->fetch_assoc()) {
        $ventas[] = [
            "nombre_curso" => $row["nombre_curso"],                 // Nombre del curso
            "alumnos_inscritos" => $row["alumnos_inscritos"],         // Número de alumnos inscritos
            "nivel_promedio_cursado" => $row["nivel_promedio_cursado"], // Nivel promedio cursado
            "total_ingresos" => $row["total_ingresos"],               // Total de ingresos
            "fecha_pago" => $row["fecha_pago"],                       // Fecha del pago
            "forma_pago" => $row["forma_pago"]          
        ];
    }

    if (count($ventas) > 0) {
        echo json_encode(["status" => "success", "ventas" => $ventas]);
    } else {
        echo json_encode(["status" => "success", "ventas" => [], "message" => "No se encontraron resultados."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error al ejecutar la consulta."]);
}

$stmt->close();
?>
