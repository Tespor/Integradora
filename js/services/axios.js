//Servicio Login
var usernameJS = "";
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
                usernameJS = response.data.usuario;
                crearCookie('usuario',usernameJS, 1);
                crearCookie('token',generateToken(), 1);
                window.location.href = response.data.endpoint;
            } else {
                alert(response.data.message);
            }
        })
        .catch(function (error) {
            console.error('Error en el inicio de sesión', error);
        });
    });

    //Servicio Registrar Cliente
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
    

function crearCookie(nombre, valor, horas) {
    const fecha = new Date();
    fecha.setTime(fecha.getTime() + horas * 60 * 60 * 1000);
    const expires = "expires=" + fecha.toUTCString();
    document.cookie = `${nombre}=${valor}; ${expires}; path=/`; 
}

function generateToken() {
    const randomPart = Math.random().toString(36).substring(2);
    const timePart = Date.now().toString(36); 
    return randomPart + timePart;
}




    
    
