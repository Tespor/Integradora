//Servicio Login
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();

        const nombre_usuario = document.getElementById('nombre_usuario').value;
        const contrasena = document.getElementById('contrasena').value;

        axios.post('login.php', {
            nombre_usuario: nombre_usuario,
            contrasena: contrasena
        })
        .then(function (response) {
            if (response.data.status === 'success') {
                window.location.href = response.data.redirect;
            } else {
                alert(response.data.message);
            }
        })
        .catch(function (error) {
            console.error('Error en el inicio de sesión', error);
        });
    });
    //Servicio Registrar Usuario
    