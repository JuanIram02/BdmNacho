<?php
include '../Connection.php';

session_start();
date_default_timezone_set('America/Mexico_City');

// Verificar si la sesión contiene el `id_usuario` (instructor_id)
if (!isset($_SESSION["id_usuario"])) {
    echo "0"; // No hay sesión activa
    exit();
}

// Obtener el ID del instructor desde la sesión
$instructor_id = $_SESSION["id_usuario"];

// Recibir datos del formulario
$titulo = $_POST["titulo"] ?? null;
$descripcion = $_POST["descripcion"] ?? null;
$precio = $_POST["precio"] ?? null;
$niveles = $_POST["niveles"] ?? null;
$categoria_id = $_POST["categoria_id"] ?? null;

// Manejar la imagen principal
$imagen = null;
if (isset($_FILES["imagenes"]["tmp_name"][0]) && !empty($_FILES["imagenes"]["tmp_name"][0])) {
    $imagen = addslashes(file_get_contents($_FILES["imagenes"]["tmp_name"][0])); // Convertir la imagen en binarios
}

// Crear conexión a la base de datos
$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

// Verificar que todos los datos requeridos están presentes
if ($titulo && $descripcion && $precio && $instructor_id && $imagen) {
    // Construir consulta para el procedimiento almacenado
    $query = "CALL SpCurso(
        NULL, 
        '$titulo', 
        '$descripcion', 
        '$imagen', 
        $precio, 
        'C', 
        'A', 
        1, 
        $instructor_id, 
        NULL,
        NULL,
        'INSERT'
    )";

    if (mysqli_query($mysqli, $query)) {
        echo "1"; // Éxito
    } else {
        echo "0"; // Error al ejecutar la consulta
    }
} else {
    echo "0"; // Datos incompletos
}
?>
