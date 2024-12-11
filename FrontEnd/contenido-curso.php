<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenido del Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css"> <!-- Reutilizando estilos existentes -->
</head>
<body>
    <!-- Contenedor del Menú -->
    <div id="menu-container"></div>

    <button class="return" onclick="history.back()">Regresar</button>
    <div class="container mt-5">
        <h3 class="text-center">Contenido del Curso: [Nombre del Curso]</h3>
        <div class="row mt-4">
            <div class="col-md-8">
                <video controls class="w-100 mb-4">
                    <source src="ruta/a/tu/video.mp4" type="video/mp4">
                    Tu navegador no soporta la etiqueta de video.
                </video>
                <p>Descripción del nivel actual...</p>
            </div>
            <div class="col-md-4">
                <h5>Niveles del Curso</h5>
                <ul class="list-group">
                    <li class="list-group-item">Nivel 1: Introducción</li>
                    <li class="list-group-item">Nivel 2: Conceptos Básicos</li>
                    <!-- Lista de niveles adicionales -->
                </ul>
            </div>
        </div>
    </div>
    <!-- Contenedor del Footer -->
    <div id="footer-container"></div>
    <!-- Incluir el menú y el footer con JavaScript -->
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
