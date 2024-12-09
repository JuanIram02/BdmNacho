<?php
include 'Connection.php';
session_start();
$database = new Database("localhost", "cursO", "root", "");

// Establece la conexión a la base de datos
$database->connect();
$mysqli = $database->getConnection();
if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $mysqli->prepare("CALL spInicioSesion(?, ?, @id_usuario, @nombre_usuario, @tipo, @mensaje)");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $stmt->close();

  $result = $mysqli->query("SELECT @id_usuario, @nombre_usuario, @tipo, @mensaje");
  $row = $result->fetch_assoc();
  $id_usuario = $row['@id_usuario'];
  $nombre_usuario = $row['@nombre_usuario'];
  $tipo = $row['@tipo'];
  $mensaje = $row['@mensaje'];

  if ($id_usuario !== null) {
	if($tipo == "Administrador"){
		  // Almacenar los datos del usuario en variables de sesión
		  $_SESSION['id_usuario'] = $id_usuario;
		  $_SESSION['nombre_usuario'] = $nombre_usuario;
		  $_SESSION['tipo'] = $tipo;
		  echo 1;
	} else if($tipo == "Estudiante"){
		// Almacenar los datos del usuario en variables de sesión
		$_SESSION['id_usuario'] = $id_usuario;
		$_SESSION['nombre_usuario'] = $nombre_usuario;
		$_SESSION['tipo'] = $tipo;
		echo 3;
  	}else if($tipo == "Instructor"){
		// Almacenar los datos del usuario en variables de sesión
		$_SESSION['id_usuario'] = $id_usuario;
		$_SESSION['nombre_usuario'] = $nombre_usuario;
		$_SESSION['tipo'] = $tipo;
		echo 2;
  	}else if($tipo == "Superadministrador"){
		// Almacenar los datos del usuario en variables de sesión
		$_SESSION['id_usuario'] = $id_usuario;
		$_SESSION['nombre_usuario'] = $nombre_usuario;
		$_SESSION['tipo'] = $tipo;
		echo 4;
  	}
  
  } else {
    echo 0;
  }
}
?>