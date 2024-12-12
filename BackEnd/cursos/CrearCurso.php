<?php
include '../Connection.php';

session_start();
date_default_timezone_set('America/Mexico_City');

// Verificar si la sesión está activa
if (!isset($_SESSION["id_usuario"])) {
    echo "0"; // No hay sesión activa
    exit();
}

$instructor_id = $_SESSION["id_usuario"];

$titulo = $_POST["titulo"] ?? null;
$descripcion = $_POST["descripcion"] ?? null;
$precio = $_POST["precio"] ?? null;
$niveles = $_POST["niveles"] ?? null;
$categoria_id = $_POST["categoria_id"] ?? null;
$url_video = ""; // Inicializar URL del video como vacío

// Verificar la imagen
$imagen = null;
if (isset($_FILES["imagenes"]["tmp_name"][0]) && !empty($_FILES["imagenes"]["tmp_name"][0])) {
    $imagen = addslashes(file_get_contents($_FILES["imagenes"]["tmp_name"][0])); // Convertir la imagen en binarios
}

// Verificar si el archivo de video está presente y no tiene errores
if (isset($_FILES["video"]) && $_FILES["video"]["error"] === UPLOAD_ERR_OK) {
    // Definir el directorio donde se guardarán los videos
    $targetDir = "../uploads/videos/";

    // Verificar si la carpeta de destino existe
    if (!is_dir($targetDir)) {
        // Si no existe, intentar crear la carpeta
        if (!mkdir($targetDir, 0777, true)) {
            echo "Error al crear la carpeta de videos.";
            exit();
        }
    }

    // Crear un nombre único para el video para evitar sobrescribir archivos existentes
    $targetFile = $targetDir . uniqid("video_") . "." . pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);

    // Intentar mover el archivo de video cargado a la carpeta de destino
    if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
        $url_video = 'uploads/videos/' . basename($targetFile); // URL relativa del video
    } else {
        echo "Error al subir el video. Por favor, intente nuevamente.";
        exit();
    }
} else {
    echo "No se ha recibido un archivo de video válido.";
    exit();
}

// Conexión a la base de datos
$database = new Database("localhost", "curso", "root", "");
$database->connect();
$mysqli = $database->getConnection();

// Verificar que todos los campos necesarios estén presentes
if ($titulo && $descripcion && $precio && $instructor_id && $imagen && $url_video) {
    // Ejecutar el procedimiento almacenado para insertar el curso
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
        '$url_video',
        'INSERT'
    )";

    // Verificar si la inserción fue exitosa
    if (mysqli_query($mysqli, $query)) {
        echo "1"; // Curso registrado exitosamente
    } else {
        echo "0"; // Error al ejecutar la consulta
    }
} else {
    echo "0"; // Datos incompletos
}
?>
