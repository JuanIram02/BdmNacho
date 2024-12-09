<!-- menu.html -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="../Imagenes/cursO.png" alt="Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Mi Perfil
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="perfilDropdown">
                        <li><a class="dropdown-item" href="perfil.php">Mi Información</a></li>
                        <li><a class="dropdown-item" href="mis-cursos.php">Mis Cursos</a></li>
                        <li><a class="dropdown-item" href="kardex.php">Kardex</a></li>
                        <li><a class="dropdown-item" href="ventas.php">Mis Ventas</a></li>
                        <li><a class="dropdown-item" href="mensajeria.php">Mensajes</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crearCurso.php"><i class="bi bi-box-arrow-in-right"></i>Crear Curso</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i>Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
