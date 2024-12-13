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
    <link rel="stylesheet" href="./css/Landing.css">
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
                <!-- <li><a href="Acceptproducto.php">Productos por aceptar</a></li> -->
                <li><a href="#" onclick="abrirModal()">Crear categoría</a></li>
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
<div id="modalCrearCategoria" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h2 style="text-align: center; margin-bottom: 20px">Crear Categoría</h2>
        <form id="formCategoria" method="POST">
            <div>
                <label for="nombreCategoria">Nombre categoría:</label>
                <input type="text" id="nombreCategoria" name="nombreCategoria" required>
            </div>
            <div style="margin-block: 20px">
                <label for="descripcion">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>
            <button id="submitCategoria" type="submit" class="btn btn-green">Crear</button>
        </form>
    </div>
</div>
<div class="container search-bar mt-4">
    <!-- <h3>Filtro de cursos</h3> -->
    <div class="row w-75 m-auto m-box-2" style="margin-block: 10px;">
    <input type="text" id="search-course" class="form-control w-50" style="flex: 1;" placeholder="Buscar por nombre de curso...">
    <button id="search-button" class="btn btn-green" style="width: 50px; height: 40px; margin-left: 15px; margin-block: auto;">
        <img src="../Imagenes/lupa.svg" alt="buscar" style="width: 20px;">
    </button>
</div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <select id="categories-select" class="form-select me-2" style="flex: 1;">
            <option value="">Todas las Categorías</option>
            <option value="">IT & Software</option>
            <option value="">Marketing</option>
            <option value="">Carpinteria</option>
            <option value="">Plomería</option>
            <option value="">Otros</option>
        </select>
        <input type="date" class="form-control" style="flex: 1;">
    </div>
</div>
    <div class="container mt-5">
        <div class="row" id="courses-container">
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso1.png" class="card-img-top" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Curso de IT & Software</h5>
                        <p class="card-text">Aprende desde lo básico hasta avanzado.</p>
                        <p><strong>Costo:</strong> $50</p>
                        <a href="curso.php" class="btn btn-green">Ver Curso</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso2.png" class="card-img-top" alt="Curso 2">
                    <div class="card-body">
                        <h5 class="card-title">Curso de Marketing Digital</h5>
                        <p class="card-text">Conviértete en un experto en marketing online.</p>
                        <p><strong>Costo:</strong> $75</p>
                        <a href="curso.php" class="btn btn-green">Ver Curso</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="../Imagenes/Curso3.png" class="card-img-top" alt="Curso 3">
                    <div class="card-body">
                        <h5 class="card-title">Curso de Diseño Digital</h5>
                        <p class="card-text">Aprende las herramientas básicas para diseñar desde tu computadora.</p>
                        <p><strong>Costo:</strong> $35</p>
                        <a href="curso.php" class="btn btn-green">Ver Curso</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
        <div id="footer-container"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function abrirModal() {
            document.getElementById("modalCrearCategoria").style.display = "block";
        }

        // Función para cerrar el modal
        function cerrarModal() {
            document.getElementById("modalCrearCategoria").style.display = "none";
        }

        // Cerrar el modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById("modalCrearCategoria");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
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

            $("#formCategoria").submit(function (event) {
                event.preventDefault();

                const nombreCategoria = $("#nombreCategoria").val();
                const descripcion = $("#descripcion").val();

                console.log(nombreCategoria)
                console.log(descripcion)

                if (!nombreCategoria || !descripcion) {
                    alert("Por favor, completa todos los campos.");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "../BackEnd/categorias/crearCategoria.php", 
                    data: { 
                        nombreCategoria: nombreCategoria, 
                        descripcion: descripcion 
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#submitCategoria").text("Creando...").prop("disabled", true);
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            alert("¡Categoría creada exitosamente!");
                            loadCategories();
                            cerrarModal();
                        } else {
                            alert(`Error: ${response.message}`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud:", error);
                        alert("Ocurrió un error al intentar crear la categoría. Por favor, inténtalo más tarde.");
                    },
                    complete: function () {
                        $("#submitCategoria").text("Crear").prop("disabled", false);
                    }
                });
            });
        });


        $(document).ready(function () {
            function loadCourses() {
                $.ajax({
                    type: "GET", 
                    url: "../BackEnd/cursos/AllCursos.php", 
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

            function searchCoursesByName(searchTerm) {
                $.ajax({
                    type: "GET",
                    url: "../BackEnd/cursos/busquedaNombre.php",
                    data: { search: searchTerm },
                    dataType: "json",
                    beforeSend: function () {
                        $("#courses-container").html('<p class="text-center">Buscando cursos...</p>');
                    },
                    success: function (response) {
                        $("#courses-container").empty();

                        if (response.status === "success") {
                            const cursos = response.cursos;

                            if (cursos.length === 0) {
                                $("#courses-container").html('<p class="text-center">No se encontraron cursos.</p>');
                                return;
                            }

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
                            $("#courses-container").html(`<p class="text-center">${response.message}</p>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al buscar los cursos:", error);
                        $("#courses-container").html('<p class="text-center text-danger">Error al buscar los cursos. Intenta nuevamente más tarde.</p>');
                    }
                });
            }

            $("#search-button").click(function () {
                const searchTerm = $("#search-course").val().trim();
                if (searchTerm) {
                    searchCoursesByName(searchTerm);
                } else {
                    loadCourses()
                }
            });

            $("#search-course").keypress(function (e) {
                if (e.which === 13) {
                    const searchTerm = $(this).val().trim();
                    if (searchTerm) {
                        searchCoursesByName(searchTerm);
                    } else {
                        loadCourses()
                    }
                }
            });

            $("#categories-select").change(function () {
                const categoriaId = $(this).val();

                if (categoriaId) {
                    $.ajax({
                        type: "GET",
                        url: "../BackEnd/cursos/busquedaCategoria.php",
                        data: { categoria_id: categoriaId },
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
                                $("#courses-container").html('<p class="text-center">No se encontraron cursos para esta categoría.</p>');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error al cargar los cursos:", error);
                            $("#courses-container").html('<p class="text-center text-danger">Error al cargar los cursos. Intenta nuevamente más tarde.</p>');
                        }
                    });
                } else {
                    loadCourses();
                }
            });

        });

    </script>
    
</body>
</html>
