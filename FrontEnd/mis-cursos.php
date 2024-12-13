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
    <title>Mis Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/Landing.css">
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
                <!-- <li><a href="Acceptproducto.php">Productos por aceptar</a></li> -->
                <li><a href="reportesAdmin.php">Reportes de usuarios</a></li>
                <li><a href="users.php">Chat</a></li>
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
<section>
    <div class="container mt-5">
        <h3 class="text-center">Mis Cursos</h3>
        <div class="row mt-4" id="courses-container">
            <!-- Ejemplo de curso 1 -->
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso1.png" class="card-img-top" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Curso de IT & Software</h5>
                        <p class="card-text">Aprende desde lo básico hasta avanzado en el mundo del software.</p>
                        <a href="contenido-curso.html" class="btn btn-green">Empezar</a>
                    </div>
                </div>
            </div>
            <!-- Ejemplo de curso 2 -->
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso2.png" class="card-img-top" alt="Curso 2">
                    <div class="card-body">
                        <h5 class="card-title">Curso de Marketing Digital</h5>
                        <p class="card-text">Conviértete en un experto en marketing digital.</p>
                        <a href="contenido-curso.html" class="btn btn-green">Empezar</a>
                    </div>
                </div>
            </div>
            <!-- Ejemplo de curso 3 -->
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso3.png" class="card-img-top" alt="Curso 3">
                    <div class="card-body">
                        <h5 class="card-title">Curso de Design Digital</h5>
                        <p class="card-text">Aprende las herramientas básicas para diseñar desde tu computadora.</p>
                        <a href="contenido-curso.html" class="btn btn-green">Empezar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- Contenedor del Footer -->
    <div id="footer-container"></div>
    <!-- Incluir el menú y el footer con JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {



            fetch('footer.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('footer-container').innerHTML = data;
                });
        });

        $(document).ready(function () {
            function loadCourses() {
                $.ajax({
                    type: "GET", 
                    url: "../BackEnd/cursos/misCursos.php", 
                    dataType: "json",
                    beforeSend: function () {
                        $("#courses-container").html('<p class="text-center">Cargando cursos...</p>');
                    },
                    success: function (response) {
                        $("#courses-container").empty();

                        if (response.status === "success") {
                            const cursos = response.cursos;

                            cursos.forEach(function (curso) {
                                const card = `
                                    <div class="col-md-4">
                                        <div class="card course-card">
                                            <img src="data:image/jpeg;base64,${curso.imagen}" class="card-img-top" alt="${curso.titulo}">
                                            <div class="card-body">
                                                <h5 class="card-title">${curso.titulo}</h5>
                                                <p class="card-text">${curso.descripcion}</p>
                                                <p><strong>Costo:</strong> $${curso.precio}</p>
                                                <a href="curso.php?id=${curso.id_curso}" class="btn btn-green">Ver Curso</a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $("#courses-container").append(card);
                            });
                        } else {
                            $("#courses-container").html('<p class="text-center">No se encontraron cursos disponibles.</p>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar los cursos:", error);
                        $("#courses-container").html('<p class="text-center text-danger">Error al cargar los cursos. Intenta nuevamente más tarde.</p>');
                    }
                });
            }

            loadCourses();
        })
    </script>
</body>
</html>
