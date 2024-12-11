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
            <p>Costo total: $49.99</p>
        </div>

        <div class="row mt-4">
            <!-- Columna del formulario de tarjeta -->
            <div class="col-md-6">
                <h2>Compra en línea</h2>
                <form>
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
                    <input type="hidden" name="amount" value="49.99">
                    <input type="hidden" name="currency_code" value="USD">
                    <button type="submit" class="btn btn-warning">Pagar con PayPal</button>
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
        </script>
    </div>
</body>
</html>
