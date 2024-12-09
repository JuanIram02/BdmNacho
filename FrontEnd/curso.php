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
    <title>Curso - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <!-- Contenedor del Menú -->
    <div id="menu-container"></div>

    <button class="return" onclick="history.back()">Regresar</button>
    <div class="container mt-5">
        <div class="course-header">
            <h1>Curso de IT & Software</h1>
            <div class="form-group">
                <label for="nivelSelect">Niveles:</label>
                <select id="nivelSelect" class="form-select mt-2">
                    <option value="">Selecciona un nivel...</option>
                    <option value="nivel.html">Nivel 1</option>
                    <option value="nivel.html">Nivel 2</option>
                    <option value="nivel.html">Nivel 3</option>
                    <option value="nivel.html">Nivel 4</option>
                    <option value="nivel.html">Nivel 5</option>
                    <option value="nivel.html">Nivel 6</option>
                    <option value="nivel.html">Nivel 7</option>
                    <option value="nivel.html">Nivel 8</option>
                    <option value="nivel.html">Nivel 9</option>
                    <option value="nivel.html">Nivel 10</option>
                </select>
            </div>
            <p>Costo total: $49.99</p>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <h4>Descripción del curso</h4>
                <p>Este curso cubre los fundamentos de software y IT...</p>
                <div class="video-container">
                    <video controls>
                        <source src="ruta/a/tu/video.mp4" type="video/mp4">
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
            <button class="btn btn-green" onclick="alert('Este curso no está en venta actualmente')">Comprar</button>
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

            document.getElementById('nivelSelect').addEventListener('change', function() {
                const selectedLevel = this.value;
                if (selectedLevel) {
                    window.location.href = selectedLevel;
                }
            });
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
                                $('.course-header + p').text(curso.descripcion);

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

                            alert('Ocurrió un error al cargar los detalles del curso.');
                        }
                    });
                } else {
                    alert('No se proporcionó un ID de curso válido.');
                }
            });
        </script>



    </div>
</body>
</html>
