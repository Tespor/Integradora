document.addEventListener('DOMContentLoaded', function() {
    
    const menLateral = document.querySelector('.menu-lateral');//flex
    const datos = document.querySelector('.datosCuentas');//block

    axios.get('sesion/validar_sesion.php')
        .then(response => {
            const data = response.data;

            if (data.status === 1) {
                datos.classList.remove('opacity-0');
                menLateral.classList.remove('opacity-0');
                
            } else if (data.status === 0) {
                alert('No existe una sesión activa');
                window.location.href = 'index.html';
            }
        })
        .catch(error => {
            console.error('Error al verificar la sesión:', error);
        });
});


// Destruir sesión al cerrar la página
/*
window.onbeforeunload = function () {
    const [navigationEntry] = performance.getEntriesByType('navigation');
    const isReload = navigationEntry.type === 'reload'; // Detecta si es una recarga

    if (!isReload) {
        // Solo destruir la sesión si no es una recarga
        axios.get('sesion/destruir_sesion.php')
            .then(response => {
                console.log('Sesión destruida');
            })
            .catch(error => {
                console.error('Error al destruir la sesión:', error);
            });
    }
};
*/

// Destruir sesión al dar clic en el botón - cerrar sesión
document.getElementById('LogOut').addEventListener('click', function() {
    // Hacer la solicitud para destruir la sesión
    axios.get('sesion/destruir_sesion.php')
        .then(response => {
            alert("Sesión cerrada");
            window.location.href = 'index.html'; // Redirigir a la página de inicio
        })
        .catch(error => {
            console.error('Error al destruir la sesión:', error);
        });
});
