<?php
include "Librerias.php";
// Verificar si el usuario ha iniciado sesión
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/LandingReportes.css">
    <script src="./scripts/sweetalert.js"></script>
</head>

<body>
<header>
    <a class="navbar-brand" href="index.php">
        <img src="../Imagenes/cursO.png" alt="Logo" style="height: 40px;">
    </a>
    <?php
    if (isset($_SESSION['id_usuario'])) {
        // Usuario ha iniciado sesión
        $tipoUsuario = $_SESSION['tipo'];
        // Dependiendo del tipo de usuario, mostrar contenido diferente
        if ($tipoUsuario == 'Estudiante') {
            ?>
            <ul>
                <li><a href="Perfil.php">
                    <?php echo $_SESSION['nombre_usuario'] ?>
                </a></li>
                <li><a href="mis-cursos.php">Mis cursos</a></li>
                <li><a href="kardex.php">Kardex</a></li>
                <li><a href="mensajeria.php">Chat</a></li>
                <li><a href="login.php" onclick="CerrarSesion();">Cerrar sesión</a></li>
            </ul>
            <?php
        } elseif ($tipoUsuario == 'Instructor') {
            // Mostrar contenido para instructores
            ?>
            <ul>
                <li><a href="Perfil.php">
                    <?php echo $_SESSION['nombre_usuario'] ?>
                </a></li>
                <li><a href="crearCurso.php">Crear curso</a></li>
                <li><a href="ventas.php">Reporte de ventas</a></li>
                <li><a href="mensajeria.php">Chat</a></li>
                <li><a href="login.php" onclick="CerrarSesion();">Cerrar sesión</a></li>
            </ul>
            <?php
        } elseif ($tipoUsuario == 'Administrador') {
            // Mostrar contenido para administradores
            ?>
            <ul>
                <li><a href="#">
                        <?php echo $_SESSION['nombre_usuario'] ?>
                    </a></li>
                <li><a href="reportesAdmin.php">Reportes de usuarios</a></li>
                <li><a href="mensajeria.php">Chat</a></li>
                <li><a href="login.php" onclick="CerrarSesion();">Cerrar sesión</a></li>
            </ul>
            <?php
        }
    } else {
        // Usuario no ha iniciado sesión
        header("Location: login.php");
        exit();
    }
    ?>
</header>
<main class="reports-container">
<section class="report-section instructors">
    <h2>Instructores</h2>
    <input type="text" placeholder="Buscar instructores..." class="search-input">
    <ul class="list instructors-list">
        <li>
            <h3>Instructor 1</h3>
            <p>Email: instructor1@example.com</p>
            <p>Teléfono: 555-1234</p>
        </li>
        <li>
            <h3>Instructor 2</h3>
            <p>Email: instructor2@example.com</p>
            <p>Teléfono: 555-5678</p>
        </li>
        <!-- Agrega más instructores aquí -->
    </ul>
</section>

<section class="report-section students">
    <h2>Estudiantes</h2>
    <input type="text" placeholder="Buscar estudiantes..." class="search-input">
    <ul class="list students-list">
        <li>
            <h3>Estudiante 1</h3>
            <p>Email: estudiante1@example.com</p>
            <p>Teléfono: 555-4321</p>
        </li>
        <li>
            <h3>Estudiante 2</h3>
            <p>Email: estudiante2@example.com</p>
            <p>Teléfono: 555-8765</p>
        </li>
        <!-- Agrega más estudiantes aquí -->
    </ul>
</section>

</main>
        <div id="footer-container"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('menu.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('menu-container').innerHTML = data;
                });

            fetch('footer.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('footer-container').innerHTML = data;
                });
        });
    </script>
    
</body>
</html>
