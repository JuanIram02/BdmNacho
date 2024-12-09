<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$query = "CALL SpCategoria(NULL, NULL, NULL, NULL, 'SELECT_ALL')";
$result = mysqli_query($mysqli, $query);

if ($result) {
    $categorias = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $categorias[] = [
            "id_categoria" => $row["id_categoria"],
            "nombre" => $row["NombreCategoria"],
            "descripcion" => $row["Descripcion"]
        ];
    }

    echo json_encode(["status" => "success", "categorias" => $categorias]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudieron obtener las categorías."]);
}
?>
