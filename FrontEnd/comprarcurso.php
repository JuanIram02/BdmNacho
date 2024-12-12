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
    <link rel="stylesheet" href="./css/Landing.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AdFbQWVQCpdfQQ3S61HMQBiHVHhccRi-KhwIjdaacw3PLaYmunffQzNBSiAPZHcTrdQlD5AtpvsxQ4lD&currency=USD"></script>
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
            <!-- Columna del formulario de tarjeta -->
            <div class="col-md-6">
                <h2>Compra en línea</h2>
                <form id="pago-tarjeta">
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Nombre en la tarjeta</label>
                        <input type="text" class="form-control" id="cardName" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Número de tarjeta</label>
                        <input type="text" class="form-control" id="cardNumber" maxlength="16" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardExpiry" class="form-label">Fecha de vencimiento</label>
                        <input type="text" class="form-control" id="cardExpiry" placeholder="MM/AA" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardCVC" class="form-label">CVC</label>
                        <input type="text" class="form-control" id="cardCVC" maxlength="3" required>
                    </div>
                    <input type="hidden" name="amount" id="costo">
                    <button type="submit" class="btn btn-primary">Pagar con tarjeta</button>
                </form>
            </div>

            <!-- Columna de PayPal -->
            <div class="col-md-6">
                <h2>Compra con PayPal</h2>
                <p>Puedes completar tu compra de manera segura con PayPal.</p>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="tu-email@ejemplo.com">
                    <input type="hidden" name="item_name" value="Curso IT & Software">
                    <input type="hidden" name="amount" id="costoPaypal">
                    <input type="hidden" name="currency_code" value="USD">
                    <div id="paypal-button-container"></div>
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
        </script>

        <script>
            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const idCurso = urlParams.get('id');

                paypal.Buttons({
                    createOrder: function (data, actions) {
                        const costo = $("#costo").val();

                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: costo 
                                },
                                description: `Pago por el curso ID: ${idCurso}`
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        
                        return actions.order.capture().then(function (details) {
                            
                            $.ajax({
                                url: '../BackEnd/pagos/procesarPago.php',
                                type: 'POST',
                                data: {
                                    idCurso: idCurso,
                                    costo: $("#costo").val(),
                                    forma_pago: "paypal",
                                    paypalOrderId: data.orderID
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status === 'success') {
                                        alert('Pago realizado con éxito. Gracias por tu compra.');
                                        window.location.href = `curso.php?id=${idCurso}`;
                                    } else {
                                        console.error('Error en el procesamiento del pago:', response.message);
                                        alert(response.message);
                                        window.location.href = `curso.php?id=${idCurso}`;
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error en la solicitud AJAX:', status, error, xhr.responseText);
                                    alert('Ocurrió un error al procesar el pago. Por favor, inténtalo más tarde.');
                                }
                            });
                        });
                    },
                    onError: function (err) {
                        console.error('Error en PayPal:', err);
                        alert('Ocurrió un error con PayPal. Por favor, inténtalo más tarde.');
                    }
                }).render('#paypal-button-container');

                if (idCurso) {
                    $.ajax({
                        url: `../BackEnd/cursos/obtenerCurso.php`, 
                        type: 'GET', 
                        data: { id: idCurso },
                        dataType: 'json', 
                        success: function (data) {
                            if (data.status === 'success') {
                                const curso = data.curso;

                                console.log(curso)

                                $('.course-header h1').text(curso.titulo);
                                $('.course-header p').text(`Costo total: $${curso.costo}`);

                                console.log(curso.costo);

                                $('#costo').val(curso.costo);

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
                } else {
                    alert('No se proporcionó un ID de curso válido.');
                }

                $("#btn-comprar").click(function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    const idCurso = urlParams.get('id');
                    window.location.href = `comprarcurso.php?id=${idCurso}`;
                });

                $("#pago-tarjeta").on("submit", function (event) {
                    event.preventDefault(); 

                    const cardName = $("#cardName").val();
                    const cardNumber = $("#cardNumber").val();
                    const cardExpiry = $("#cardExpiry").val();
                    const cardCVC = $("#cardCVC").val();

                    const urlParams = new URLSearchParams(window.location.search);
                    const idCurso = urlParams.get('id');

                    const costo = $("#costo").val();

                    console.log(costo)

                    $.ajax({
                        url: `../BackEnd/pagos/procesarPago.php`,
                        type: 'POST',
                        data: {
                            nombreTarjeta: cardName,
                            numeroTarjeta: cardNumber,
                            vencimientoTarjeta: cardExpiry,
                            cvcTarjeta: cardCVC,
                            idCurso: idCurso,
                            costo: costo,
                            forma_pago: "tarjeta"
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Pago realizado con éxito. Gracias por tu compra.');
                                window.location.href = `curso.php?id=${idCurso}`;
                            } else {
                                console.error('Error en el procesamiento del pago:', response.message);
                                alert(response.message);
                                window.location.href = `curso.php?id=${idCurso}`;
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', status, error, xhr.responseText);
                            alert('Ocurrió un error al procesar el pago. Por favor, inténtalo más tarde.');
                        }
                    });
                });

            });
        </script>
    </div>
</body>
</html>
