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
    <title>Kardex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
        <h3 class="text-center">Kardex</h3>

        <!-- Filtros -->
        <div class="filter-container mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="dateRange" class="form-label">Rango de fechas de inscripción:</label>
                    <input type="date" id="startDate" class="form-control">
                    <input type="date" id="endDate" class="form-control mt-2">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="category" class="form-label">Categoría:</label>
                    <select class="form-select" id="categories-select">
                        <option value="">Todas</option>
                        <option value="it">IT & Software</option>
                        <option value="marketing">Marketing</option>
                        <option value="design">Design</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Mostrar:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="completedCourses">
                        <label class="form-check-label" for="completedCourses">Solo cursos terminados</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="activeCourses">
                        <label class="form-check-label" for="activeCourses">Solo cursos activos</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla estilo Kardex -->
<!-- Tabla estilo Kardex -->
<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Nombre del curso</th>
            <th>Progreso</th>
            <th>Fecha de inscripción</th>
            <th>Último acceso</th>
            <th>Fecha de terminación</th>
            <th>Estado</th>
            <th>Certificado</th> <!-- Nueva columna -->
        </tr>
    </thead>
    <tbody>
        <!-- Curso 1 -->
        <tr>
            <td>Curso de Programación en Python</td>
            <td>75%</td>
            <td>2024-09-01</td>
            <td>2024-09-18</td>
            <td>-</td>
            <td>Incompleto</td>
            <td>-</td> <!-- Sin certificado -->
        </tr>
        <!-- Curso 2 -->
        <tr>
            <td>Curso de Marketing Digital</td>
            <td>100%</td>
            <td>2024-08-10</td>
            <td>2024-09-12</td>
            <td>2024-09-12</td>
            <td>Completo</td>
            <td>
                <button class="btn btn-green" onclick="descargarCertificado('Curso de Marketing Digital')">Descargar</button>
            </td> <!-- Botón para descargar certificado -->
        </tr>
    </tbody>
</table>
</section>

    </div>
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
            function loadCategories() {
                $.ajax({
                    type: "GET", 
                    url: "../BackEnd/categorias/AllCategorias.php", 
                    dataType: "json",
                    beforeSend: function () {
                        $("#categories-select").html('<option value="">Cargando categorías...</option>');
                    },
                    success: function (response) {
                        $("#categories-select").empty();

                        if (response.status === "success") {
                            const categorias = response.categorias;

                            $("#categories-select").append('<option value="">Selecciona una categoría</option>');

                            categorias.forEach(function (categoria) {
                                if(categoria.nombre !== "root"){
                                    const option = `<option value="${categoria.id_categoria}">${categoria.nombre}</option>`;
                                    $("#categories-select").append(option);
                                }
                            });
                        } else {
                            $("#categories-select").html('<option value="">No se encontraron categorías</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar las categorías:", error);
                        $("#categories-select").html('<option value="">Error al cargar categorías</option>');
                    }
                });
            }

            loadCategories();

            function cargarKardex() {
                // Obtener valores de los filtros
                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();
                const category = $("#categories-select").val();
                const completed = $("#completedCourses").is(":checked") ? 1 : 0;
                const active = $("#activeCourses").is(":checked") ? 1 : 0;

                // Enviar los valores como parámetros GET
                $.ajax({
                    type: "GET",
                    url: "../BackEnd/cursos/kardex.php",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        category: category,
                        completed: completed,
                        active: active
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("tbody").html('<tr><td colspan="7" class="text-center">Cargando datos...</td></tr>');
                    },
                    success: function (response) {
                        $("tbody").empty();

                        if (response.status === "success") {
                            const cursos = response.cursos;

                            if (cursos.length === 0) {
                                $("tbody").html('<tr><td colspan="7" class="text-center">No se encontraron cursos.</td></tr>');
                                return;
                            }

                            // Renderizar los cursos en la tabla
                            cursos.forEach(function (curso) {
                                const row = `
                                    <tr>
                                        <td>${curso.nombre}</td>
                                        <td>${curso.progreso}%</td>
                                        <td>${curso.fecha_inscripcion || "-"}</td>
                                        <td>${curso.ultimo_acceso || "-"}</td>
                                        <td>${curso.fecha_terminacion || "-"}</td>
                                        <td>${curso.estado}</td>
                                        <td>
                                            ${curso.estado === "Completo" ? 
                                                `<button class="btn btn-green" onclick="descargarCertificado('${curso.nombre}')">Descargar</button>` : 
                                                "-"
                                            }
                                        </td>
                                    </tr>
                                `;
                                $("tbody").append(row);
                            });
                        } else {
                            $("tbody").html(`<tr><td colspan="7" class="text-center">${response.message}</td></tr>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar el Kardex:", error);
                        $("tbody").html('<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos. Intenta nuevamente más tarde.</td></tr>');
                    }
                });
            }

            cargarKardex();

            // Recargar Kardex cuando cambien los filtros
            $("#startDate, #endDate, #categories-select, #completedCourses, #activeCourses").change(function () {
                cargarKardex();
            });

        });
    </script>
<script>
    async function descargarCertificado(nombreCurso) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape', 'mm', 'a4'); // Crear un PDF horizontal

        // Cargar la imagen de fondo
        const imageUrl = '../imagenes/Certificado.png'; 
        const img = new Image();
        img.src = imageUrl;

        img.onload = function () {
            // Dibujar la imagen de fondo
            doc.addImage(img, 'PNG', 0, 0, 297, 210); // Ajustar tamaño y posición según tu diseño

            // Datos del certificado
            const nombreUsuario = "Nombre del Usuario"; // Esto debería ser dinámico, obteniendo el nombre del usuario actual
            const fecha = new Date().toLocaleDateString();

            // Contenido del certificado (superpuesto sobre el diseño)
            doc.setFontSize(20);
            doc.setFont('times', 'bold');
            doc.text(nombreUsuario, 148.5, 100, null, null, 'center'); // Ajusta la posición según tu diseño
            
            doc.setFontSize(16);
            doc.setFont('times', 'normal');
            doc.text(`Por haber completado satisfactoriamente el curso:`, 148.5, 120, null, null, 'center');
            
            doc.setFontSize(20);
            doc.setFont('times', 'bold');
            doc.text(nombreCurso, 148.5, 140, null, null, 'center');
            
            doc.setFontSize(16);
            doc.setFont('times', 'normal');
            doc.text(`Fecha de finalización: ${fecha}`, 148.5, 160, null, null, 'center');

            // Descargar el PDF
            doc.save(`Certificado_${nombreCurso}.pdf`);
        };
    }
</script>


    
</body>
</html>
