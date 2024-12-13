<!-- <?php
include "Librerias.php";
// Verificar si el usuario ha iniciado sesión
session_start();
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/Landing.css">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <!-- Contenedor del Menú -->
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

    <button class="return" onclick="history.back()">Regresar</button>
    <div class="container mt-5">
        <div class="course-header">
            <h1>Curso de IT & Software</h1>
            <p>Costo total: $49.99</p>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <h4>Descripción del curso</h4>
                <p id="descripcion">Este curso cubre los fundamentos de software y IT...</p>

                <div class="tabs-container">
                    <ul id="tabs" class="nav nav-tabs">
                        <div class="nav-link active">
                            <p>Introduccion</p>
                            <!-- Aquí podemos agregar más detalles del nivel si es necesario -->
                        </div>
                        <div class="nav-link">
                            <p>Nivel 1</p>
                            <!-- Aquí podemos agregar más detalles del nivel si es necesario -->
                        </div>
                        <div class="nav-link">
                            <p>Nivel 2</p>
                            <!-- Aquí podemos agregar más detalles del nivel si es necesario -->
                        </div>
                    </ul>
                </div>
                <div class="video-container">
                    <video id="video-player" controls>
                        <source id="video-source" src="ruta/a/tu/video.mp4" type="video/mp4">
                        Tu navegador no soporta la etiqueta de video.
                    </video>
                </div>
            </div>
            <div class="col-md-4">
                <br><br><br>
                <div id="cursoCarrusel" class="carousel slide mt-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../Imagenes/It&Software(curso).jpg" class="d-block w-100" alt="Imagen del curso 1">
                        </div>
                        <div class="carousel-item">
                            <img src="../Imagenes/It&Software(curso2).jpg" class="d-block w-100" alt="Imagen del curso 2">
                        </div>
                        <div class="carousel-item">
                            <img src="../Imagenes/It&Software(curso3).jpg" class="d-block w-100" alt="Imagen del curso 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#cursoCarrusel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#cursoCarrusel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        

        <div class="comprar-curso mt-4">
            <h4>Comprar Curso</h4>
            <button class="btn btn-green" id="btn-comprar">Comprar</button>
        </div>

        <div class="mt-4">
            <h4>Valoración del curso</h4>
            <button class="btn btn-green" onclick="alert('Curso valorado satisfactoriamente')">Me gusta</button>
            <button class="btn btn-danger" onclick="alert('Curso valorado satisfactoriamente')">No me gusta</button>
        </div>

        <!-- Sección de Comentarios -->
        <div class="comment-section mt-4">
            <h4>Comentarios</h4>
            <div class="card mt-3">
                <div class="card-body">
                    <strong>Usuario1</strong> - <small>Fecha: 2024-09-21</small>
                    <p>Excelente curso, lo recomiendo.</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <strong>Usuario2</strong> - <small>Fecha: 2024-09-20</small>
                    <p>El curso fue útil, pero algo corto.</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <strong>Usuario3</strong> - <small>Fecha: 2024-07-03</small>
                    <p><em>Comentario eliminado por administrador.</em></p>
                </div>
            </div>

            <div id="formulario-com" class="mt-4">
                <h4>Deja tu comentario</h4>
                <form id="commentForm">
                    <div class="mb-3">
                        <label for="commentText" class="form-label">Comentario</label>
                        <textarea class="form-control" id="commentText" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-green">Enviar</button>
                </form>
            </div>
        </div>

        <div id="footer-container"></div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                fetch('footer.html')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('footer-container').innerHTML = data;
                    });
            });

            // document.getElementById('nivelSelect').addEventListener('change', function() {
            //     const selectedLevel = this.value;
            //     if (selectedLevel) {
            //         window.location.href = selectedLevel;
            //     }
            // });
        </script>

        <script>
            document.getElementById('commentForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const commentText = document.getElementById('commentText').value;

                const newComment = document.createElement('div');
                newComment.classList.add('card', 'mt-3');
                newComment.innerHTML = `
                    <div class="card-body">
                        <strong>Usuario anónimo</strong> - <small>Fecha: ${new Date().toLocaleDateString()}</small>
                        <p>${commentText}</p>
                    </div>
                `;

                const commentSection = document.querySelector('#formulario-com');
                commentSection.insertBefore(newComment, commentSection.firstChild);

                document.getElementById('commentForm').reset();
            });
        </script>

        <script>
            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const idCurso = urlParams.get('id');

                let niveles = [];

                function updateVideo(url) {
                    $('.video-container video source').attr('src', url || 'ruta/a/video/default.mp4');
                    $('.video-container video')[0].load();
                }

                if (idCurso) {
                    $.ajax({
                        url: `../BackEnd/cursos/obtenerCurso.php`, 
                        type: 'GET', 
                        data: { id: idCurso },
                        dataType: 'json', 
                        success: function (data) {
                            if (data.status === 'success') {
                                const curso = data.curso;

                                $('.course-header h1').text(curso.titulo);
                                $('.course-header p').text(`Costo total: $${curso.costo}`);
                                $('.video-container video source').attr('src', curso.video || 'ruta/a/video/default.mp4');
                                $('.video-container video')[0].load();
                                $('#descripcion').text(curso.descripcion);

                                const carouselInner = $('#cursoCarrusel .carousel-inner');
                                carouselInner.html(`
                                    <div class="carousel-item active">
                                        <img src="data:image/jpeg;base64,${curso.imagen}" class="d-block w-100" alt="Imagen del curso">
                                    </div>
                                `);
                            } else {
                                console.error('Error al obtener los datos del curso:', data.message);
                                alert('No se pudieron cargar los detalles del curso. Inténtalo más tarde.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error al cargar los detalles del curso:', status, error, xhr.responseText);
                            alert('Ocurrió un error al cargar los detalles del curso.');
                        }
                    });

                    $.ajax({
                        type: "GET", 
                        url: "../BackEnd/niveles/obtenerNiveles.php", 
                        data: { id: idCurso },
                        dataType: "json",
                        success: function (response) {
                            $("#tabs").empty();

                            if (response.status === "success") {
                                niveles = response.niveles;

                                console.log(niveles)

                                niveles.forEach(function (nivel, index) {
                                    const isActive = index === 0 ? 'active' : '';

                                    const option = `<div class="nav-link ${isActive}" data-index="${index}">
                                                        <p>${nivel.descripcion}</p>
                                                        <!-- Aquí podemos agregar más detalles del nivel si es necesario -->
                                                    </div>`;
                                    $("#tabs").append(option);
                                    
                                });

                                const firstVideo = niveles[0];
                                updateVideo("../BackEnd/" + firstVideo.url_video);
                            } 
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al cargar los niveles:", error);
                        }
                    });
                } else {
                    alert('No se proporcionó un ID de curso válido.');
                }

                $(document).on('click', '.nav-link', function () {
                    const index = $(this).data('index');
                    const selectedNivel = niveles[index];  // Usar la variable global niveles

                    // Actualizar la clase active
                    $(".nav-link").removeClass("active");
                    $(this).addClass("active");

                    // Actualizar el video en el reproductor
                    updateVideo("../BackEnd/" + selectedNivel.url_video);
                });

                $("#btn-comprar").click(function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    const idCurso = urlParams.get('id');
                    window.location.href = `comprarcurso.php?id=${idCurso}`;
                });
            });
        </script>



    </div>
</body>
</html>
