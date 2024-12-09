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
    <div id="menu-container"></div>

    <button class="return" onclick="history.back()">Regresar</button>
    <div class="container mt-5">
        <div class="course-header">
            <h1>Curso de IT & Software</h1>
            <p>Nivel 1</p>
            <p>Costo del nivel: $10</p>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <h4>Descripción del nivel</h4>
                <p>Este nivel...</p>
                <div class="video-container">
                    <video controls>
                        <source src="ruta/a/tu/video.mp4" type="video/mp4">
                        Tu navegador no soporta la etiqueta de video.
                    </video>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Valoración del nivel</h4>
            <button class="btn btn-green" onclick="alert('Curso valorado satisfactoriamente')">Me gusta</button>
            <button class="btn btn-danger" onclick="alert('Curso valorado satisfactoriamente')">No me gusta</button>
        </div>

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

    </div>
</body>
</html>
