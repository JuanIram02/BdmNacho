<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$categoria_id = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : 0;

if ($categoria_id === 0) {
    echo json_encode(["status" => "error", "message" => "Por favor selecciona una categoría válida."]);
    exit;
}

$query = "CALL SpCurso(NULL, NULL, NULL, NULL, NULL, NULL, NULL, $categoria_id, NULL, NULL, NULL, NULL, 'SELECT_BY_CATEGORY')";

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
    echo json_encode(["status" => "error", "message" => "No se encontraron resultados para la categoría seleccionada."]);
}
?>
