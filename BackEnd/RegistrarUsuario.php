<?php
include 'Connection.php';

session_start();
date_default_timezone_set('America/Mexico_City');
$username = $_POST["username"];
$password = $_POST["password"];
$Name = $_POST["Name"];
$LastNamePattern = $_POST["LastNamePattern"];
$LastNameMatern = $_POST["LastNameMatern"];
$Email = $_POST["Email"];
$SelectGeneroOption = $_POST["SelectGeneroOption"];
$DateBirthValue = $_POST["DateBirthValue"];
$SelectRolOption = $_POST["SelectRolOption"];

$database = new Database("localhost", "cursO", "root", "");

$database->connect();
$mysqli = $database->getConnection();
$query = "CALL SpUsuario(NULL, '$username', '$Name', '$LastNamePattern', '$LastNameMatern', '$SelectGeneroOption', '$DateBirthValue', '', '$Email', '$password', '$SelectRolOption', 'Activo', 'INSERT')";

if (mysqli_query($mysqli, $query)) {
    echo "1";
} else {
    echo "0";
}
?>