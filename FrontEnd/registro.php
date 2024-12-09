<?php
include "Librerias.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="../Imagenes/cursO.png" alt="Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="text-center">Registro de Usuario</h3>
        <div class="form-container mt-4">
            <form id="registroForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="id" class="form-control" id="nombreUsuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" required>
                    <small class="form-text text-muted">
                        La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial.
                    </small>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" pattern="[A-Za-z]+" title="Por favor, ingresa solo letras" required>
                </div>
                <div class="mb-3">
                    <label for="apellidoP" class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control" id="apellidoP" pattern="[A-Za-z]+" title="Por favor, ingresa solo letras" required>
                </div>
                <div class="mb-3">
                    <label for="apellidoM" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" id="apellidoM" pattern="[A-Za-z]+" title="Por favor, ingresa solo letras" required>
                </div>
                <div class="mb-3">
                    <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" required>
                </div>
                <div class="mb-3">
                    <label for="sexo" class="form-label">Sexo</label>
                    <select class="form-select" id="sexo" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Registrarse como</label>
                    <select class="form-select" id="rol" required>
                        <option value="instructor">Instructor</option>
                        <option value="estudiante">Estudiante</option>
                    </select>
                </div>
                <button type="button" class="btn-custom" onclick="RegistrarUser();">Registrarse</button>
            </form>
            <div id="error-message" class="error-message"></div>
        </div>
    </div>
    <script src="registro-val.js"></script>
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
    </script>
    <script>
        function validarContrasena(password) {
            var regex = /^(?=.*[A-Z])(?=.*[a-zñÑ])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+ñÑ]{8,}$/;
            return regex.test(password);
        }

        function RegistrarUser() {
            var valinput = "";
            var username = $("#nombreUsuario").val();
            var password = $("#password").val();
            var Name = $("#nombre").val();
            var LastNamePattern = $("#apellidoP").val();
            var LastNameMatern = $("#apellidoM").val();
            var Email = $("#email").val();
            var SelectGenero = document.getElementById('sexo');
            var SelectGeneroOption = SelectGenero.options[SelectGenero.selectedIndex].textContent;
            var DateBirth = document.getElementById('fechaNacimiento');
            var DateBirthValue = DateBirth.value;
            var SelectRol = document.getElementById('rol');
            var SelectRolOption = SelectRol.options[SelectRol.selectedIndex].textContent;

            if (username == "") {
                valinput += "Ingrese su nombre de usuario";
            }
            if (password == "") {
                if (valinput != "") {
                    valinput += ",\n"
                }
                valinput += "Falta una contraseña";
            }
            if (Name == "") {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese su nombre";
            } else if (!/^[\p{L}]+(?: [\p{L}]+)?$/u.test(Name)) {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "El nombre solo debe contener letras";
            }
            if (LastNamePattern == "") {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese su apellido paterno";
            } else if (!/^[\p{L}]+$/u.test(LastNamePattern)) {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "El apellido paterno solo debe contener letras";
            }

            if (LastNameMatern == "") {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese su apellido materno";
            } else if (!/^[\p{L}]+$/u.test(LastNameMatern)) {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "El apellido materno solo debe contener letras";
            }
            if (DateBirthValue == "") {
                if (valinput != "") {
                    valinput += ",\n";
                }
                valinput += "Ingrese su fecha de nacimiento";
            } else {
                // Obtén la fecha actual
                var fechaActual = new Date();
                var fechaComp = new Date(DateBirthValue);
                // Calcula la diferencia en años
                var edad = fechaActual.getFullYear() - fechaComp.getFullYear();

                // Verifica si la persona ya cumplió años este año
                if (
                    fechaComp.getMonth() > fechaActual.getMonth() ||
                    (fechaComp.getMonth() === fechaActual.getMonth() &&
                        fechaComp.getDate() > fechaActual.getDate())
                ) {
                    edad--;
                }

                // Verifica si la persona tiene al menos 18 años
                if (edad < 18) {
                    if (valinput != "") {
                        valinput += ",\n";
                    }
                    valinput += "Debes ser mayor de 18 años";
                }
            }
            if (Email == "") {
                if (valinput != "") {
                    valinput += ",\n"
                }
                valinput += "Ingrese su correo electronico";
            }
            if (!validarContrasena(password)) {
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
                $.ajax({
                    type: "POST",
                    url: "../BackEnd/RegistrarUsuario.php",
                    data: {
                        username: username,
                        password: password,
                        Name: Name,
                        LastNamePattern: LastNamePattern,
                        LastNameMatern: LastNameMatern,
                        Email: Email,
                        SelectGeneroOption: SelectGeneroOption,
                        DateBirthValue: DateBirthValue,
                        SelectRolOption: SelectRolOption
                    },
                    cache: false,
                    success: function (data) {
                        if (data == '1') //data == '1'
                        {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Usuario agregado Correctamente',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                window.location.href = "Login.php";
                            });
                        }
                        else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                text: "No se pudo agregar Usuario",
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function (xhr, status, error) {

                        window.location.href = "logout.php";
                    }
                });
            }
        }
    </script>
</body>
</html>
