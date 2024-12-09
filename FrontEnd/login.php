<?php
include "Librerias.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href="./css/index.css">
    <script src="scripts/sweetalert.js"></script>
    <script src="scripts/unpkg.com_jspdf@2.5.1_dist_jspdf.umd.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="margin-bottom: 50px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" style="height: 50px; 
                align-items: center; display: flexbox; justify-content: center; text-align: center;">
                <img src="../Imagenes/cursO.png" alt="Logo" style="height: 40px; 
                align-items: center; display: flexbox; justify-content: center; text-align: center;">
            </a>
            <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center">Iniciar Sesión</h3>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="text" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    <button type="button" class="btn btn-login" id="LoginButton" onclick="IniciarUser();">Iniciar sesión</button>

                </form>
                <div id="error-message" class="error-message"></div>
                <p class="mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <script src="login-val.js"></script>
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
        function validarContrasena(password) {
            var regex = /^(?=.*[A-Z])(?=.*[a-zñÑ])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+ñÑ]{8,}$/;
            return regex.test(password);
        }

        function IniciarUser() {
            var valinput = "";
            var password = $("#password").val();
            var Email = $("#email").val(); 
            if (Email == "") {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese su correo electrónico";
            } else if (!/^\S+@\S+\.\S+$/.test(Email)) {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese una dirección de correo electrónico válido";
            }
            if (password == "") {
                if (valinput != "") {
                    valinput += ",\n"
                }
                valinput += "Falta una contraseña";
            } else if (!validarContrasena(password)) {
                if (valinput != "") {
                    valinput += ",\n"
                }
                valinput += "La contraseña no cumple con los requisitos mínimos";
            }
            if (valinput != "") {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    text: valinput,
                    showConfirmButton: true
                });
                return;
            } else {
                var dataString = 'email=' + Email + '&password=' + password;
                if ($.trim(Email).length > 0 && $.trim(password).length > 0) {
                $.ajax({
                    type: "POST",
                    url: "../BackEnd/validarLogin.php",
                    data: dataString,
                    cache: false,
                    beforeSend: function () { $("#LoginButton").val('Connecting...'); },
                    success: function (data) {
                        if (data == '1') //data == '1'
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Bienvenido administrador.',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        }
                        else if (data == '3') //data == '1'
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Bienvenido Estudiante.',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        }
                        else if (data == '2') //data == '1'
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Bienvenido Instructor.',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        }else if (data == '4') //data == '1'
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Bienvenido super administrador.',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        }
                        else {
                            //Shake animation effect.
                            $("#LoginButton").val('Login')
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'El nombre de usuario o contraseña son invalidos.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function (xhr, status, error) {  
                        window.location.href = "logout.php";
                    }
                });
            }
            }
        }
    </script>
</body>
</html>
