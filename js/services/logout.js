
//=============================================================================//
//              Validacion y Eliminazion de sesion con cookies                 //
//=============================================================================//

document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('bloqueoVentana').style.display = "none";

    const usuario = obtenerCookie('usuario');
    const token = obtenerCookie('token');
    if (!usuario || !token) {
        window.location.href = 'index.html';
    } else {
        axios.get('sesion/validar_sesion.php')
        .then(response => {
            const data = response.data;
            var endpoint = "";

            if(data.status == 0 || data.rol == "0"){
                window.location.href = 'index.html';
                return;
            }
            
            switch (data.rol) {
                case "1":
                    endpoint = "Administrador";
                    break;
                case "2":
                    endpoint = "Inicio";
                    break;
            }

            if(document.title == endpoint){
                return;
            } else {
                console.log('El usuario no tiene acceso a esta ventana')
                window.location.href = 'index.html';
            }

        })
        .catch(error => {
            console.error('Error al verificar la sesión:', error);
        });
    }
});

// Destruir sesión al dar clic en el botón - cerrar sesión
document.getElementById('LogOut').addEventListener('click', function() {
    eliminarSesionPhp();
});

function eliminarSesionPhp(){
    axios.get('sesion/destruir_sesion.php')
        .then(response => {
            borrarCookie('usuario');
            borrarCookie('token');
            alert("Sesión cerrada");
            window.location.href = 'index.html';
        })
        .catch(error => {
            console.error('Error al destruir la sesión:', error);
        });
}
//=============================================================================//
//                     Cookies y funciones de inactividad                      //
//=============================================================================//

function obtenerCookie(nombre) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith(nombre + '=')) {
            return cookie.substring((nombre + '=').length);
        }
    }
    return null;
}

function borrarCookie(nombre) {
    document.cookie = `${nombre}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
}


// Desde aqui comienza la funcion de inactividad
// ===================>
let activityTimeout;
let AlertCerrarSesion;

// Función para resetear el temporizador de inactividad
function reiniciarTiempoInactividad() {
    
    clearTimeout(activityTimeout);
    clearTimeout(AlertCerrarSesion);

    //Iniciar de nuevo el timer con las variables limpias
    AlertCerrarSesion = setTimeout(() => {
        alert('Tu sesion esta a punto de expirar por inactividad');
    }, 840000)

    activityTimeout = setTimeout(() => {
        borrarCookie('usuario');
        borrarCookie('token');
        eliminarSesionPhp();
        window.location.href = 'index.html';
    }, 900000);
}

// Eventos de actividad del usuario
window.addEventListener('mousemove', reiniciarTiempoInactividad);
window.addEventListener('keydown', reiniciarTiempoInactividad);
window.addEventListener('click', reiniciarTiempoInactividad);
window.addEventListener('scroll', reiniciarTiempoInactividad);

// Iniciar el temporizador al cargar la página
reiniciarTiempoInactividad();
// ===================>
// Aqui termina la funcion de inactividad


//=============================================================================//
//                   Identificador de mas ventanas abiertas                    //
//=============================================================================//

// Identificador único para cada ventana
const sessionId = Date.now(); 

// Guardar el identificador de la ventana actual en localStorage
localStorage.setItem("activeSession", sessionId);

// Verificar si otra ventana está activa
function checkActiveSession() {
    const activeSession = localStorage.getItem("activeSession");

    if (activeSession && activeSession !== sessionId.toString()) {
        document.getElementById('bloqueoVentana').style.display = "grid";
    }
}

// Escuchar cambios en el localStorage
window.addEventListener("storage", (event) => {
    if (event.key === "activeSession") {
        checkActiveSession();
    }
});

// Verificar si hay otra ventana activa al cargar la página
checkActiveSession();

