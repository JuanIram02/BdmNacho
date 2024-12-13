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

        <!-- Bandeja de mensajes -->
        <div class="mt-5">
            <h4>Bandeja de Entrada</h4>
            <div id="bandejaMensajes" class="bandeja-mensajes">
                <!-- Mensajes específicos del curso se mostrarán aquí -->
            </div>
        </div>

        <div class="mensajes-container mt-4">
            <form id="mensajeriaForm">
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="mensaje" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Enviar Mensaje</button>
            </form>
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
                if (cursoSeleccionado > 0) {
                    cargarMensajes(cursoSeleccionado);
                    
                } else {
                    // Si no se selecciona un curso válido, limpiar la bandeja de mensajes
                    document.getElementById('bandejaMensajes').innerHTML = '';
                }
            });

            let mensajesCargados = []; // Variable global para mantener los mensajes ya cargados

            function cargarMensajes(cursoId) {
                const bandejaMensajes = document.getElementById('bandejaMensajes');

                // Realizar una solicitud AJAX para obtener los mensajes del curso seleccionado
                fetch(`../BackEnd/mensajes/obtenerMensajes.php?id=${cursoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const mensajesNuevos = data.messages;

                            // Verificar si hay cambios comparando los IDs de los mensajes
                            const idsMensajesNuevos = mensajesNuevos.map(mensaje => mensaje.id);
                            const idsMensajesCargados = mensajesCargados.map(mensaje => mensaje.id);

                            if (JSON.stringify(idsMensajesNuevos) === JSON.stringify(idsMensajesCargados)) {
                                // No hay cambios, no actualizar la bandeja
                                console.log('No hay nuevos mensajes.');
                                return;
                            }

                            // Actualizar la bandeja si hay cambios
                            bandejaMensajes.innerHTML = ''; // Limpiar mensajes previos
                            mensajesCargados = mensajesNuevos; // Actualizar los mensajes cargados

                            mensajesNuevos.forEach(mensaje => {
                                const avatar = mensaje.avatar && mensaje.avatar !== "" ? mensaje.avatar : "../Imagenes/avatar.jpg";

                                const nuevoMensaje = document.createElement('div');
                                nuevoMensaje.classList.add('card', 'mt-3');
                                nuevoMensaje.innerHTML = `
                                    <div class="card-body">
                                        <img src="${avatar}" alt="Imagen de usuario" class="img-thumbnail" width="50">
                                        <strong>${mensaje.remitente_nombre}</strong> - <small>Fecha: ${mensaje.fecha}</small>
                                        <p>${mensaje.contenido}</p>
                                    </div>
                                `;
                                bandejaMensajes.prepend(nuevoMensaje);
                            });

                            setTimeout(() => {
                                bandejaMensajes.scrollTop = bandejaMensajes.scrollHeight + 1; // Desplazarse ligeramente más allá
                            }, 100); // Pequeño retraso para asegurar que el mensaje se haya renderizado antes de hacer el scroll
                        } else {
                            bandejaMensajes.innerHTML = '<p>No se encontraron mensajes para este curso.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los mensajes:', error);
                        bandejaMensajes.innerHTML = '<p>Error al cargar los mensajes.</p>';
                    });
            }

            // Configurar un intervalo para recargar mensajes cada 5 segundos
            setInterval(() => {
                const cursoSeleccionado = document.getElementById('cursoSelect').value;
                if (cursoSeleccionado) {
                    cargarMensajes(cursoSeleccionado);
                }
            }, 5000);


            document.getElementById('mensajeriaForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const cursoSeleccionado = document.getElementById('cursoSelect').value;
                if (!cursoSeleccionado) {
                    alert('Por favor, selecciona un curso antes de enviar un mensaje.');
                    return;
                }

                const mensajeText = document.getElementById('mensaje').value;

                const mensajeData = {
                    curso_id: cursoSeleccionado,
                    contenido: mensajeText,
                };

                fetch('../BackEnd/mensajes/enviarMensaje.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(mensajeData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {              
                        cargarMensajes(cursoSeleccionado);
                    } else {
                        alert('Error al enviar el mensaje');
                    }
                })
                .catch(error => {
                    console.error('Error al enviar el mensaje:', error);
                    alert('Error al enviar el mensaje');
                });

                document.getElementById('mensajeriaForm').reset();
            });


            $(document).ready(function () {
                function loadCourses() {
                    $.ajax({
                        type: "GET", 
                        url: "../BackEnd/cursos/AllCursos.php", 
                        dataType: "json",
                        beforeSend: function () {
                            $("#cursoSelect").html('<option class="text-center">Cargando cursos...</option>');
                        },
                        success: function (response) {
                            $("#cursoSelect").empty();

                            if (response.status === "success") {
                                const cursos = response.cursos;
                                $("#cursoSelect").append("<option value='' selected disabled>Selecciona un curso</option>");
                                console.log(cursos)

                                cursos.forEach(function (curso) {
                                    const card = `
                                        <option value="${curso.id_curso}">${curso.titulo}</option>
                                    `;
                                    $("#cursoSelect").append(card);
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
