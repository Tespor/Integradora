let clicBloqueado;
//menu lateral
const btnMenu = document.getElementById('IconCompany');
const columnaGuia = document.getElementById('columnaGuia');
const Menu = document.querySelector('.menu-lateral');
const headMenu = document.getElementById('headMenu');
//Menu usuario lateral
const menuUser = document.getElementById('menuUser');
const btnToMenuser = document.getElementById('perfil');
var menuUserAbierto = false;


//Posicion del menu lado derecho
var opcionesMenu = Menu.getBoundingClientRect();
const menuPosition = opcionesMenu.left + opcionesMenu.width;

//Posicion del Header lado derecho
    // Obtiene el ancho total
    const fullWidth = headMenu.getBoundingClientRect().width;
    // Obtiene el padding izquierdo y derecho del elemento
    const paddingRight = parseFloat(getComputedStyle(headMenu).paddingRight);
    // Calcula el ancho sin padding ni bordes
    var contentWidth = fullWidth - paddingRight;
    const headPosition = headMenu.getBoundingClientRect().left + contentWidth;


//variables para tiempo y aperturas
var menuAbierto = false;
var time = 600;
var tamañoExtra = 0;
var anchoPantalla = 0;

btnMenu.addEventListener('click', function(){
    if(clicBloqueado) return;

    if (menuAbierto) {
        //abre menu
        Menu.style.animation = `mostrar ${time}ms forwards`;
        menuAbierto = false;
        monitorMenuPosition("abriendo", headPosition, tamañoExtra, time);
        
        menuUser.style.right = "-200px";
        menuUser.style.opacity = "0";
        menuUserAbierto = !menuUserAbierto;
    }
    else {
        //cierra menu
        Menu.style.animation = `guardar ${time}ms forwards`;
        menuAbierto = true;
        monitorMenuPosition("cerrando", headPosition, tamañoExtra, time);
    }
});

function monitorMenuPosition(accion, headPosition, tamañoExtra, time) {
    // Guardar el tiempo inicial
    const startTime = Date.now();

    const checkPosition = setInterval(function () {
        // Obtener la posición actual del menú
        const menuPosition = Menu.getBoundingClientRect().right;

        // Si el menú ha alcanzado o sobrepasado el headPosition
        if (menuPosition >= headPosition) {
            const tiempoTranscurrido = Date.now() - startTime;
            const timeAnimate = time - tiempoTranscurrido;            
            // Configura la transición y ajusta el padding-right
            headMenu.style.transition = `padding-right ${timeAnimate}ms`;
            headMenu.style.paddingRight = "0px";

            clearInterval(checkPosition);
        }
        
        // Si el menú se está cerrando y pasa por debajo de los píxeles del encabezado
        if (accion === "abriendo" && menuPosition < headPosition) {
            const tiempoTranscurrido = Date.now() - startTime;
            const timeAnimate = time - tiempoTranscurrido;            
            // Configura la transición y ajusta el padding-right a 0
            headMenu.style.transition = `padding-right ${timeAnimate}ms ${tiempoTranscurrido}`;
            headMenu.style.paddingRight = `${tamañoExtra}px`;

            clearInterval(checkPosition);
        }
    }, 50); // Intervalo de 50 ms para verificar la posición
}


function sincronizacionDeTamaños() {
    
    headMenu.style.transition = `padding-right 0ms`;
    medidaColumna = columnaGuia.offsetWidth;//medida de la columna
    anchoPantalla = window.innerWidth;
    

    if(anchoPantalla <= 767){
        //Dispositivos pequeños
        clicBloqueado = false
        Menu.style.width = "100%";
    } else {
        //Dispositivos grandes
        clicBloqueado = true
        Menu.style.width = `${medidaColumna}px`;
        if (menuAbierto) {
            //abre menu
            Menu.style.animation = `mostrar ${time}ms forwards`;
            menuAbierto = false;
            monitorMenuPosition("abriendo", headPosition, tamañoExtra, time);
        }
    }

    //Posicion del menu lado derecho
    opcionesMenu = Menu.getBoundingClientRect();
    const menuPositionRT = opcionesMenu.left + opcionesMenu.width;

    //Posicion del Header lado derecho
    var contentWidthRT = fullWidth - paddingRight;
    const headPositionRT = headMenu.getBoundingClientRect().left + contentWidthRT;
    tamañoExtra = menuPositionRT - headPositionRT;
    headMenu.style.paddingRight = `${tamañoExtra}px`;

}

// Llamo a la función cuando carga la página
sincronizacionDeTamaños();

// Escucha el evento resize para actualizar en tiempo real
window.addEventListener('resize', () => {
        sincronizacionDeTamaños();
});


//=============================================================================//
//                    Menu lateral de usuario al dar click                     //
//=============================================================================//
btnToMenuser.addEventListener('click', function(){
    if (menuUserAbierto){
        menuUser.style.right = "-200px";
        menuUser.style.opacity = "0";
    } else {
        menuUser.style.right = "5px";
        menuUser.style.opacity = "1";
    }
    menuUserAbierto = !menuUserAbierto;
});
