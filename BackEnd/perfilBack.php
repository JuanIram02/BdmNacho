<?php

session_start();

include '../Backend/Connection.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? null;
$id = $_SESSION['id_usuario'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'No se ha iniciado sesión.']);
    exit;
}

$database = new Database("localhost", "cursO", "root", "");
$database->connect();
$mysqli = $database->getConnection();

if ($action == 'CallPerfil') {
    $stmt = $mysqli->prepare("CALL SpUsuario(?, '', '', '', '', '', null, '', '', '', '', '', 'SELECT')");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            // Convertir el avatar a base64 si está presente
            $avatarBlob = $row['avatar'] ?? '';
            $row['avatar'] = base64_encode($avatarBlob);
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    } else {
        echo json_encode(['error' => 'Error en el procedimiento almacenado']);
    }
    $stmt->close();
}

if ($action == 'UpdatePerfil') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre_usuario = $data['nombre_usuario'] ?? '';
    $genero = $data['genero'] ?? '';
    $fecha_nacimiento = $data['fecha_nacimiento'] ?? null;
    $password = $data['password'] ?? ''; // Asegúrate de enviar la contraseña

    $stmt = $mysqli->prepare("CALL SpUsuarioUpdate(?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id, $nombre_usuario, $genero, $fecha_nacimiento, $password);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'message' => $row['mensaje']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en la actualización: ' . $stmt->error]);
    }
    $stmt->close();
}


if ($action === 'uploadAvatar') {
    $avatar = $_FILES['avatar'] ?? null;

    if ($avatar && $avatar['error'] === UPLOAD_ERR_OK) {
        // Validación de tamaño y tipo de archivo
        if ($avatar['size'] > 500000) { // 500 KB de límite de tamaño
            echo json_encode(['status' => 'error', 'message' => 'El tamaño del archivo es demasiado grande.']);
            exit;
        }

        $fileData = file_get_contents($avatar['tmp_name']);
        $stmt = $mysqli->prepare("CALL SpUsuario(?, '', '', '', '', '', null, ?, '', '', '', '', 'UPDATE_PHOTO')");
        $stmt->bind_param("is", $id, $fileData);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Avatar actualizado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el avatar']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo del avatar']);
    }
}

$mysqli->close();
