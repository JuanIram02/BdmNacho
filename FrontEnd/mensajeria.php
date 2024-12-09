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
    <title>Mensajería</title>
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
    <button class="return" onclick="history.back()">Regresar</button>
    <div class="container mt-5">
        <h3 class="text-center">Mensajería</h3>

        <!-- Selector de Curso -->
        <div class="mb-4">
            <label for="cursoSelect" class="form-label">Selecciona un Curso</label>
            <select class="form-select" id="cursoSelect">
                <option value="" selected disabled>Elige un curso</option>
                <option value="ITSoftware">Curso de IT & Software</option>
                <option value="Marketing101">Marketing 101</option>
                <!-- Agrega más opciones según los cursos disponibles -->
            </select>
        </div>

        <div class="form-container mt-4">
            <form id="mensajeriaForm">
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Enviar Mensaje</button>
            </form>
        </div>

        <!-- Bandeja de mensajes -->
        <div class="mt-5">
            <h4>Bandeja de Entrada</h4>
            <div id="bandejaMensajes">
                <!-- Mensajes específicos del curso se mostrarán aquí -->
            </div>
        </div>
    </div>
    <!-- Contenedor del Footer -->
    <div id="footer-container"></div>
    <!-- Incluir el menú y el footer con JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Evento para cambiar el curso
            document.getElementById('cursoSelect').addEventListener('change', function() {
                const cursoSeleccionado = this.value;
                cargarMensajes(cursoSeleccionado);
            });

            // Función para cargar mensajes según el curso seleccionado
            function cargarMensajes(curso) {
                const bandejaMensajes = document.getElementById('bandejaMensajes');
                bandejaMensajes.innerHTML = ''; // Limpiar mensajes previos

                // Simulación de carga de mensajes
                if (curso === 'ITSoftware') {
                    const mensajes = [
                        {usuario: 'Instructor 1', fecha: '2024-09-15 14:30', texto: 'Hola, ¿tienes alguna pregunta sobre el curso?'},
                        {usuario: 'Instructor 2', fecha: '2024-09-14 10:00', texto: 'Te recuerdo que la siguiente clase es el lunes.'}
                    ];
                    mensajes.forEach(mensaje => {
                        const nuevoMensaje = document.createElement('div');
                        nuevoMensaje.classList.add('card', 'mt-3');
                        nuevoMensaje.innerHTML = `
                            <div class="card-body">
                                <img src="ruta/a/imagen.jpg" alt="Imagen de usuario" class="img-thumbnail" width="50">
                                <strong>${mensaje.usuario}</strong> - <small>Fecha: ${mensaje.fecha}</small>
                                <p>${mensaje.texto}</p>
                            </div>
                        `;
                        bandejaMensajes.appendChild(nuevoMensaje);
                    });
                } else if (curso === 'Marketing101') {
                    // Agregar lógica para cargar mensajes del curso 'Marketing101'
                }
                // Agregar más condiciones para otros cursos
            }

            // Evento para enviar mensaje
            document.getElementById('mensajeriaForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const cursoSeleccionado = document.getElementById('cursoSelect').value;
                if (!cursoSeleccionado) {
                    alert('Por favor, selecciona un curso antes de enviar un mensaje.');
                    return;
                }

                const mensajeText = document.getElementById('mensaje').value;

                // Crear un nuevo mensaje
                const nuevoMensaje = document.createElement('div');
                nuevoMensaje.classList.add('card', 'mt-3');
                nuevoMensaje.innerHTML = `
                    <div class="card-body">
                        <img src="ruta/a/imagen.jpg" alt="Imagen de usuario" class="img-thumbnail" width="50">
                        <strong>Usuario</strong> - <small>Fecha: ${new Date().toLocaleDateString()} Hora: ${new Date().toLocaleTimeString()}</small>
                        <p>${mensajeText}</p>
                    </div>
                `;

                // Añadir el mensaje a la bandeja de mensajes
                document.getElementById('bandejaMensajes').prepend(nuevoMensaje);

                // Limpiar el formulario
                document.getElementById('mensajeriaForm').reset();
            });
</section>
            // Cargar el menú y el footer
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
