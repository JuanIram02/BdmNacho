<?php
include "Librerias.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/perfil.css">
    <script src="../Libs/moment.js"></script>
    <script src="./FrontEnd/scripts/sweetalert.js"></script>
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
                <li><a href="Acceptproducto.php">Productos por aceptar</a></li>
                <li><a href="AdminPage.php">Crear categorias</a></li>
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
<div class="container">
    <div class="profile-container">
        <h3 class="text-center">Mi Perfil</h3>
        
        <!-- Avatar -->
        <div class="avatar-container">
            <img src="../imagen/avatar.jpg" alt="Avatar" id="avatar-img" class="avatar-image">
            <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
            <button id="edit-avatar-button" class="edit-button">Cambiar avatar</button>
        </div>

        <!-- Formulario de información -->
        <form id="user-info-form" enctype="multipart/form-data">
            <div class="user-info">
                <div class="info-row">
                    <label for="user-type-input">Tipo de usuario:</label>
                    <input type="text" id="user-type-input" readonly disabled>
                </div>
                <div class="info-row">
                    <label for="username-input">Nombre de usuario:</label>
                    <input type="text" id="username-input" readonly>
                </div>
                <div class="info-row">
                    <label for="name-input">Nombre:</label>
                    <input type="text" id="name-input" readonly>
                </div>
                <div class="info-row">
                    <label for="first-surname-input">Apellido Materno:</label>
                    <input type="text" id="first-surname-input" readonly>
                </div>
                <div class="info-row">
                    <label for="last-surname-input">Apellido Paterno:</label>
                    <input type="text" id="last-surname-input" readonly>
                </div>
                <div class="info-row">
                    <label for="gender-input">Género:</label>
                    <select id="gender-input" name="genero" disabled>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="info-row">
                    <label for="birthdate-input">Fecha de nacimiento:</label>
                    <input type="date" id="birthdate-input" readonly>
                </div>
                <div class="info-row">
                    <label for="email-input">Email:</label>
                    <input type="email" id="email-input" readonly>
                </div>
                <div class="info-row">
                    <label for="password-input">Contraseña:</label>
                    <div class="password-container">
                        <input type="password" id="password-input" placeholder="Contraseña" readonly>
                        <button type="button" id="toggle-password" class="password-toggle">Mostrar</button>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <button type="button" id="edit-btn" class="btn btn-dark">Editar</button>
            <button type="submit" id="save-btn" class="btn btn-green" disabled>Guardar Cambios</button>
        </form>
    </div>
</div>


</section>
    <!-- Contenedor del Footer -->
    <div id="footer-container"></div>
    <!-- Incluir el menú y el footer con JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/Perfilscript.js"></script>
</body>
</html>
