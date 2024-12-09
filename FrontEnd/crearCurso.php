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
    <title>Registro de Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/crearCurso.css">
    <script src="scripts/sweetalert.js"></script>
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
    <div class="container form-container">
        <h2 class="mb-4">Registro de Curso</h2>
        <form id="courseForm">
            <div class="mb-3">
                <label for="courseTitle" class="form-label">Título del Curso</label>
                <input type="text" class="form-control" id="courseTitle" required>
            </div>

            <div class="mb-3">
                <label for="courseDescription" class="form-label">Descripción del Curso</label>
                <textarea class="form-control" id="courseDescription" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="coursePrice" class="form-label">Precio del Curso</label>
                <input type="number" class="form-control" id="coursePrice" min="0" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="courseLevels" class="form-label">Niveles</label>
                <input type="number" class="form-control" id="courseLevels" min="1" max="50" required>
            </div>

            <div class="mb-3">
                <label for="courseImages" class="form-label">Imágenes del Curso</label>
                <input type="file" class="form-control" id="courseImages" accept="image/*" multiple>
            </div>

            <div class="mb-3">
                <label for="courseVideo" class="form-label">Video del Curso</label>
                <input type="file" class="form-control" id="courseVideo" accept="video/*">
            </div>

            <button type="button" class="btn btn-green" onclick="RegistrarCurso()">Registrar Curso</button>
        </form>
    </div>

    <script>
        function RegistrarCurso() {
            var valinput = "";
            var titulo = $("#courseTitle").val();
            var descripcion = $("#courseDescription").val();
            var precio = $("#coursePrice").val();
            var niveles = $("#courseLevels").val();
            var imagenes = $("#courseImages")[0].files;
            var video = $("#courseVideo")[0].files;

            if (titulo.trim() === "") {
                valinput += "Ingrese el título del curso.\n";
            }

            if (descripcion.trim() === "") {
                valinput += "Ingrese la descripción del curso.\n";
            }

            if (precio.trim() === "" || parseFloat(precio) <= 0) {
                valinput += "Ingrese un precio válido para el curso.\n";
            }

            if (niveles.trim() === "" || parseInt(niveles) <= 0 || parseInt(niveles) > 50) {
                valinput += "Ingrese un número de niveles válido (1-50).\n";
            }

            if (imagenes.length === 0) {
                valinput += "Seleccione al menos una imagen para el curso.\n";
            }

            if (valinput !== "") {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    text: valinput.trim(),
                    showConfirmButton: true
                });
                return;
            }

            var formData = new FormData();
            formData.append("titulo", titulo);
            formData.append("descripcion", descripcion);
            formData.append("precio", precio);
            formData.append("niveles", niveles);

            for (var i = 0; i < imagenes.length; i++) {
                formData.append("imagenes[]", imagenes[i]);
            }

            if (video.length > 0) {
                formData.append("video", video[0]);
            }

            $.ajax({
                type: "POST",
                url: "../BackEnd/cursos/CrearCurso.php", 
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function () {
                    Swal.fire({
                        title: 'Registrando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function (data) {
                    Swal.close(); 
                    if (data === '1') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Curso registrado exitosamente.',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function () {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Hubo un problema al registrar el curso.',
                            text: data,
                            showConfirmButton: true
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error en la conexión.',
                        text: 'Por favor, intente nuevamente.',
                        showConfirmButton: true
                    });
                }
            });
        }
    </script>

    <!-- <script>
        document.getElementById('courseForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const courseTitle = document.getElementById('courseTitle').value;
            const courseDescription = document.getElementById('courseDescription').value;
            const coursePrice = document.getElementById('coursePrice').value;
            const courseLevels = document.getElementById('courseLevels').value;
            const courseImages = document.getElementById('courseImages').files;
            const courseVideo = document.getElementById('courseVideo').files[0];

            console.log({
                title: courseTitle,
                description: courseDescription,
                price: coursePrice,
                levels: courseLevels,
                images: courseImages,
                video: courseVideo
            });

            alert('Curso registrado exitosamente!');
            document.getElementById('courseForm').reset();
        });
    </script> -->
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('menu.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('menu-container').innerHTML = data;
                });
        });
    </script>
</body>

</html>
