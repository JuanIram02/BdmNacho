<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$query = "CALL SpCurso(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SELECT_ALL')";
$result = mysqli_query($mysqli, $query);

if ($result) {
    $cursos = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $cursos[] = [
            "id_curso" => $row["id"],
            "titulo" => $row["titulo"],
            "descripcion" => $row["descripcion"],
            "precio" => $row["costo"],
            "imagen" => base64_encode($row["imagen"])
        ];
    }

    echo json_encode(["status" => "success", "cursos" => $cursos]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron obtener los cursos."]);
}
?>
