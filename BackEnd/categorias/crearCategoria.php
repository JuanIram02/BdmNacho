<?php
header('Content-Type: application/json');

include '../Connection.php';

$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

$nombre = isset($_POST['nombreCategoria']) ? $_POST['nombreCategoria'] : null;
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;

// Verificar que los datos obligatorios no sean nulos
if (!$nombre || !$descripcion) {
    echo json_encode([
        "status" => "error",
        "message" => "El nombre y la descripción de la categoría son obligatorios."
    ]);
    exit;
}

// Llamar al procedimiento almacenado con el operador 'INSERT'
$stmt = $mysqli->prepare("CALL SpCategoria(NULL, ?, ?, NULL, 'INSERT')");
$stmt->bind_param("ss", $nombre, $descripcion);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Categoría creada exitosamente."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error al crear la categoría."
    ]);
}

$stmt->close();
?>
