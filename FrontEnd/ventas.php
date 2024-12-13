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
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/LandingVentas.css">
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
        <h3 class="text-center">Reporte de Ventas</h3>

        <!-- Filtros -->
        <div class="filter-container mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="dateRange" class="form-label">Rango de fechas de creación:</label>
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
                        <input class="form-check-input" type="checkbox" id="activeCourses">
                        <label class="form-check-label" for="activeCourses">Solo cursos activos</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reporte de ventas por curso -->
        <h5 class="text-center mb-4">Ventas por Curso</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre del curso</th>
                    <th>Alumnos inscritos</th>
                    <th>Nivel promedio cursado</th>
                    <th>Total de ingresos</th>
                </tr>
            </thead>
            <tbody id="bodyVentas">
                <!-- Curso 1 -->
                <tr>
                    <td>Curso de Programación en Python</td>
                    <td>150</td>
                    <td>75%</td>
                    <td>$15,000.00</td>
                </tr>
                <!-- Curso 2 -->
                <tr>
                    <td>Curso de Marketing Digital</td>
                    <td>85</td>
                    <td>60%</td>
                    <td>$8,500.00</td>
                </tr>
            </tbody>
            <tfoot>
                <tr id="total-tarjeta">
                    <td colspan="3" class="text-end"><strong>Total de ingresos (Tarjeta):</strong></td>
                    <td>$18,000.00</td>
                </tr>
                <tr id="total-paypal">
                    <td colspan="3" class="text-end"><strong>Total de ingresos (Paypal):</strong></td>
                    <td>$5,500.00</td>
                </tr>
            </tfoot>
        </table>

            <!-- Detalle por alumno -->
    <h5 class="text-center mb-4">Detalle por Alumno</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del alumno</th>
                <th>Fecha de inscripción</th>
                <th>Nivel de avance</th>
                <th>Precio pagado</th>
                <th>Forma de pago</th>
            </tr>
        </thead>
        <tbody id="bodyPagos">
            <!-- Alumno 1 -->
            <tr>
                <td>Juan Pérez</td>
                <td>01 Sep 2024</td>
                <td>80%</td>
                <td>$100.00</td>
                <td>Tarjeta de crédito</td>
            </tr>
            <!-- Alumno 2 -->
            <tr>
                <td>María López</td>
                <td>05 Sep 2024</td>
                <td>100%</td>
                <td>$120.00</td>
                <td>Paypal</td>
            </tr>
            <!-- Aqui se puede repetir según haya más aliumnos -->
        </tbody>
        <tfoot>
            <tr id="total-pagos">
                <td colspan="4" class="text-end"><strong>Total de ingresos:</strong></td>
                <td>$220.00</td>
            </tr>
        </tfoot>
    </table>

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

            function cargarVentas() {

                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();
                const category = $("#categories-select").val();
                const active = $("#activeCourses").is(":checked") ? 1 : 0;

                $.ajax({
                    type: "GET",
                    url: "../BackEnd/pagos/reporteVentas.php",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        category: category,
                        active: active
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center">Cargando datos...</td></tr>');
                    },
                    success: function (response) {
                        $("#bodyVentas").empty();

                        if (response.status === "success") {
                            const ventas = response.ventas;
                            let totalTarjeta = 0;
                            let totalPaypal = 0;

                            if (ventas.length === 0) {
                                $("#bodyVentas").html('<tr><td colspan="6" class="text-center">No se encontraron ventas.</td></tr>');
                                return;
                            }

                            // Renderizar las ventas en la tabla
                            ventas.forEach(function (venta) {
                                // Acumular los ingresos por forma de pago
                                if (venta.forma_pago === 't') {
                                    totalTarjeta += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                } else if (venta.forma_pago === 'p') {
                                    totalPaypal += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                }

                                const row = `
                                    <tr>
                                        <td>${venta.nombre_curso}</td>
                                        <td>${venta.alumnos_inscritos}</td>
                                        <td>${venta.nivel_promedio_cursado}%</td>
                                        <td>${venta.total_ingresos}</td>
                                    </tr>
                                `;
                                $("#bodyVentas").append(row);
                            });

                            // Actualizar los totales en el pie de la tabla
                            $("#total-tarjeta td:last").text(`$${totalTarjeta.toFixed(2)}`);
                            $("#total-paypal td:last").text(`$${totalPaypal.toFixed(2)}`);

                        } else {
                            $("#bodyVentas").html(`<tr><td colspan="6" class="text-center">${response.message}</td></tr>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar las ventas:", error);
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos. Intenta nuevamente más tarde.</td></tr>');
                    }
                });

            }

            cargarVentas();

            // Recargar Kardex cuando cambien los filtros
            $("#startDate, #endDate, #categories-select, #activeCourses").change(function () {
                cargarVentas();
            });

            function cargarVentas() {

                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();
                const category = $("#categories-select").val();
                const active = $("#activeCourses").is(":checked") ? 1 : 0;

                $.ajax({
                    type: "GET",
                    url: "../BackEnd/pagos/reporteVentas.php",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        category: category,
                        active: active
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center">Cargando datos...</td></tr>');
                    },
                    success: function (response) {
                        $("#bodyVentas").empty();

                        if (response.status === "success") {
                            const ventas = response.ventas;
                            let totalTarjeta = 0;
                            let totalPaypal = 0;

                            if (ventas.length === 0) {
                                $("#bodyVentas").html('<tr><td colspan="6" class="text-center">No se encontraron ventas.</td></tr>');
                                return;
                            }

                            // Renderizar las ventas en la tabla
                            ventas.forEach(function (venta) {
                                // Acumular los ingresos por forma de pago
                                if (venta.forma_pago === 't') {
                                    totalTarjeta += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                } else if (venta.forma_pago === 'p') {
                                    totalPaypal += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                }

                                const row = `
                                    <tr>
                                        <td>${venta.nombre_curso}</td>
                                        <td>${venta.alumnos_inscritos}</td>
                                        <td>${venta.nivel_promedio_cursado}%</td>
                                        <td>${venta.total_ingresos}</td>
                                    </tr>
                                `;
                                $("#bodyVentas").append(row);
                            });

                            // Actualizar los totales en el pie de la tabla
                            $("#total-tarjeta td:last").text(`$${totalTarjeta.toFixed(2)}`);
                            $("#total-paypal td:last").text(`$${totalPaypal.toFixed(2)}`);

                        } else {
                            $("#bodyVentas").html(`<tr><td colspan="6" class="text-center">${response.message}</td></tr>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar las ventas:", error);
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos. Intenta nuevamente más tarde.</td></tr>');
                    }
                });

            }

            cargarVentas();

            // Recargar Kardex cuando cambien los filtros
            $("#startDate, #endDate, #categories-select, #activeCourses").change(function () {
                cargarVentas();
            });

            function cargarVentas() {

                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();
                const category = $("#categories-select").val();
                const active = $("#activeCourses").is(":checked") ? 1 : 0;

                $.ajax({
                    type: "GET",
                    url: "../BackEnd/pagos/reporteVentas.php",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        category: category,
                        active: active
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center">Cargando datos...</td></tr>');
                    },
                    success: function (response) {
                        $("#bodyVentas").empty();

                        if (response.status === "success") {
                            const ventas = response.ventas;
                            let totalTarjeta = 0;
                            let totalPaypal = 0;

                            if (ventas.length === 0) {
                                $("#bodyVentas").html('<tr><td colspan="6" class="text-center">No se encontraron ventas.</td></tr>');
                                return;
                            }

                            // Renderizar las ventas en la tabla
                            ventas.forEach(function (venta) {
                                // Acumular los ingresos por forma de pago
                                if (venta.forma_pago === 't') {
                                    totalTarjeta += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                } else if (venta.forma_pago === 'p') {
                                    totalPaypal += parseFloat(venta.total_ingresos.replace(/[^0-9.-]+/g, "")); // Eliminamos símbolos de moneda
                                }

                                const row = `
                                    <tr>
                                        <td>${venta.nombre_curso}</td>
                                        <td>${venta.alumnos_inscritos}</td>
                                        <td>${venta.nivel_promedio_cursado}%</td>
                                        <td>${venta.total_ingresos}</td>
                                    </tr>
                                `;
                                $("#bodyVentas").append(row);
                            });

                            // Actualizar los totales en el pie de la tabla
                            $("#total-tarjeta td:last").text(`$${totalTarjeta.toFixed(2)}`);
                            $("#total-paypal td:last").text(`$${totalPaypal.toFixed(2)}`);

                        } else {
                            $("#bodyVentas").html(`<tr><td colspan="6" class="text-center">${response.message}</td></tr>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar las ventas:", error);
                        $("#bodyVentas").html('<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos. Intenta nuevamente más tarde.</td></tr>');
                    }
                });

            }

            cargarVentas();

            function cargarPagos() {

                const startDate = $("#startDate").val();
                const endDate = $("#endDate").val();

                $.ajax({
                    type: "GET",
                    url: "../BackEnd/pagos/reportePagos.php",
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#bodyPagos").html('<tr><td colspan="6" class="text-center">Cargando datos...</td></tr>');
                    },
                    success: function (response) {
                        $("#bodyPagos").empty();

                        if (response.status === "success") {
                            const pagos = response.pagos;

                            if (pagos.length === 0) {
                                $("#bodyPagos").html('<tr><td colspan="6" class="text-center">No se encontraron pagos.</td></tr>');
                                return;
                            }

                            let totalPagos = 0;

                            pagos.forEach(function (pago) {
                                const row = `
                                    <tr>
                                        <td>${pago.nombre_alumno}</td>
                                        <td>${pago.fecha_inscripcion}</td>
                                        <td>${pago.nivel_avance}%</td>
                                        <td>${pago.precio_pagado}</td>
                                        <td>${pago.forma_pago}</td>
                                    </tr>
                                `;
                                $("#bodyPagos").append(row);

                                totalPagos += parseFloat(pago.precio_pagado.replace(/[^0-9.-]+/g, "")); // Remover el símbolo '$' y convertir a número

                            });

                            $("#total-pagos td:last").text(`$${totalPagos.toFixed(2)}`);

                        } else {
                            $("#bodyPagos").html(`<tr><td colspan="6" class="text-center">${response.message}</td></tr>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error al cargar los pagos:", error);
                        $("#bodyPagos").html('<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos. Intenta nuevamente más tarde.</td></tr>');
                    }
                });

            }

            cargarPagos();

            $("#startDate, #endDate, #categories-select, #activeCourses").change(function () {
                cargarVentas();
                cargarPagos();
            });
        });
    </script>
</body>
</html>
