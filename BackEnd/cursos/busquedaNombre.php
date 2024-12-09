<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$search = isset($_GET['search']) ? $_GET['search'] : "";

if (empty($search)) {
    echo json_encode(["status" => "error", "message" => "Por favor proporciona un término de búsqueda."]);
    exit;
}

$query = "CALL SpCurso(NULL, '$search', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_BY_NAME')";

$result = mysqli_query($mysqli, $query);

if ($result) {
    $cursos = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $cursos[] = [
            "id_curso" => $row["id"],
            "titulo" => $row["titulo"],
            "descripcion" => $row["descripcion"],
            "precio" => $row["costo"],
            "imagen" => base64_encode($row["imagen"]),
            "fecha_creacion" => $row["fecha_creacion"]
        ];
    }

    echo json_encode(["status" => "success", "cursos" => $cursos]);
} else {
    echo json_encode(["status" => "error", "message" => "No se encontraron resultados para el criterio de búsqueda proporcionado."]);
}
?>
