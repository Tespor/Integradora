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
    document.querySelector('#registroForm').addEventListener('submit', function (e) {
        e.preventDefault();
    
        const nombre_usuario = document.getElementById('username').value;
        const nombre_completo = document.getElementById('fullname').value;
        const correo = document.getElementById('correo').value;
        const contrasena = document.getElementById('password').value;
    
        // Enviar los datos al servidor con Axios
        axios.post('registro.php', {
            username: nombre_usuario,
            fullname: nombre_completo,
            correo: correo,
            password: contrasena
        }, {
            headers: {
                'Content-Type': 'application/json' // Aseguramos que sea un JSON
            }
        })
        .then(function (response) {
            console.log(response.data); // Para depuración, ver la respuesta del servidor
    
            // Verificar si el registro fue exitoso
            if (response.data.status === 'success') {
                alert(response.data.message); // Mostrar mensaje de éxito
                setTimeout(function() {
                    window.location.href = "index.html"; // Redirigir a Login después del registro
                }, 1000); // Esperar 1 segundo antes de redirigir
            } else {
                alert(response.data.message); // Si el registro falló, mostrar el mensaje de error
            }
        })
        .catch(function (error) {
            console.error('Error en el registro:', error);
        });
    });
    