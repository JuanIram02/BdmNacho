$(document).ready(function () {
    $.ajax({
        url: "../Backend/perfilBack.php",
        method: "POST",
        data: { action: "CallPerfil" },
        dataType: "json",
        success: function (response) {
            $("#user-type-input").val(response.tipo);
            $("#username-input").val(response.nombre_usuario);
            $("#name-input").val(response.nombre); // Asegúrate de que este campo esté en tu HTML
            $("#first-surname-input").val(response.apellido_P); // Campo para primer apellido
            $("#last-surname-input").val(response.apellido_M); // Campo para segundo apellido
            $("#gender-input").val(response.genero);
            $("#birthdate-input").val(response.fecha_nacimiento);
            $("#email-input").val(response.email); // Campo para email
            $("#password-input").val(''); // Mantener el campo vacío por seguridad

            if (response.avatar) {
                var avatarImg = document.getElementById("avatar-img");
                avatarImg.src = "data:image/jpeg;base64," + response.avatar;
            }
        },
        error: function (xhr, status, error) {
            console.log("Error: " + error);
        }
    });
});

// Habilitar campos al hacer clic en "Editar"
document.getElementById('edit-btn').addEventListener('click', function () {
    document.getElementById('username-input').removeAttribute('readonly');
    document.getElementById('gender-input').removeAttribute('disabled');
    document.getElementById('birthdate-input').removeAttribute('readonly');
    document.getElementById('password-input').removeAttribute('readonly');

    document.getElementById('edit-btn').disabled = true;
    document.getElementById('save-btn').disabled = false;
});

// Enviar formulario para guardar cambios
document.getElementById('user-info-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const userData = {
        nombre_usuario: document.getElementById('username-input').value,
        genero: document.getElementById('gender-input').value,
        fecha_nacimiento: document.getElementById('birthdate-input').value,
        password: document.getElementById('password-input').value
    };

    fetch('../Backend/perfilBack.php', { // Cambia aquí a la ruta correcta
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'UpdatePerfil', ...userData })
    }).then(response => {
        if (response.ok) {
            alert("Perfil actualizado con éxito");
            location.reload();
        } else {
            alert("Error al actualizar el perfil");
        }
    });
});

// Mostrar u ocultar la contraseña
document.getElementById('toggle-password').addEventListener('click', function () {
    const passwordField = document.getElementById('password-input');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        this.textContent = 'Ocultar';
    } else {
        passwordField.type = 'password';
        this.textContent = 'Mostrar';
    }
});

// Subir Avatar
var avatarInput = document.getElementById('avatar-input');
document.getElementById('edit-avatar-button').addEventListener('click', function (event) {
    event.preventDefault();
    avatarInput.click();
});

$("#avatar-input").on("change", function (event) {
    event.preventDefault();
    var file = event.target.files[0];

    if (!file || !file.type.startsWith('image/')) {
        alert("Selecciona una imagen válida.");
        return;
    }

    var formData = new FormData();
    formData.append("avatar", file);
    formData.append("action", "uploadAvatar");

    $.ajax({
        url: "../Backend/perfilBack.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Actualización exitosa.',
                    showConfirmButton: false,
                    timer: 1500
                });
                var reader = new FileReader();
                var avatarImg = document.getElementById("avatar-img");
                reader.onload = function (e) {
                    avatarImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error al subir el archivo:',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Error al subir el archivo:',
                text: error,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});

// Cerrar sesión
function CerrarSesion() {
    Swal.fire({
        title: '¿Seguro que deseas cerrar sesión?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Cerrar sesión',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../Backend/cerrar_sesion.php',
                type: 'POST',
                success: function (response) {
                    window.location.href = 'LandingPage.php';
                }
            });
        }
    });
}
