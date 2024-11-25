//=============CLIENTE=================//
const EstadoServicio = document.getElementById('EstadoServicio');
const TipoContrato = document.getElementById('TipoContrato');
const ProxVencimiento = document.getElementById('ProxVencimiento');
const ConsumoMes = document.getElementById('ConsumoMes');
const ConsumoProm = document.getElementById('ConsumoProm');
const Direccion = document.getElementById('Direccion');
const AdeudoTotal = document.getElementById('adeudoTotalH1');

//Select options
const ddlCuentas = document.getElementById('ddlCuentas');

// Realiza la solicitud a obtenerDatos.php para obtener los datos
// Axios que se inicia al cargar la pagina
axios.post('clientePhp/obtenerCuentas.php')
    .then(response => {
        const data = response.data;

        if (data.error) {
            console.error(data.error); // Muestra el error si existe
            ddlCuentas.innerHTML = '<option value="">Ninguna cuenta existente</option>';
        } else {
            // Limpia el <select> antes de agregar las nuevas opciones
            ddlCuentas.innerHTML = '<option value="">Seleccione una opción</option>';

            // Itera sobre los datos y crea una opción para cada nombre
            data.forEach(nombre => {
                const option = document.createElement('option');
                option.value = nombre; // Puedes usar otro valor si necesitas un ID en su lugar
                option.textContent = nombre;
                ddlCuentas.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error("Error al obtener los datos:", error);
    });
//=============================================================================//
//                             Registrar cuenta                                //
//=============================================================================//

document.getElementById('formCuenta').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

    // Capturar los valores del formulario
    const tipoContrato = document.getElementById('ddlTipoContrato').value;
    const direccion = document.getElementById('cardHolder').value;
    const estadoServicio = document.querySelector('input[name="select"]:checked').value;

    // Crear un objeto con los datos del formulario
    const datos = {
        tipoContrato: tipoContrato,
        direccion: direccion,
        estadoServicio: estadoServicio
    };

    // Enviar los datos con Axios
    axios.post('clientePhp/registrarCuentas.php', datos)
        .then(response => {
            console.log('Respuesta del servidor:', response.data);
            alert('Cuenta creada');
            location.reload();

        })
        .catch(error => {
            console.error('Error al enviar los datos:', error);
            alert('Hubo un problema al crear cuenta');
        });
});

//=============================================================================//
//   Cuando el select cambie que muestre los datos de la cuenta del usuario    //
//=============================================================================//
//var para borrar primer option
var x = true;
ddlCuentas.addEventListener('change', function () {
    // Texto de la opción seleccionada
    const cuentaSelec = parseInt(ddlCuentas.options[ddlCuentas.selectedIndex].text);
    if (x) {
        ddlCuentas.remove(0);
        x = false;
    }
    //Mostrar datos de la cuenta
    axios.post('clientePhp/datosCuenta.php', { idCuenta: cuentaSelec },
        {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log(response.data);

            if (response.data.error) {
                d = response.data

                EstadoServicio.textContent = "";
                TipoContrato.textContent = "";
                Direccion.textContent = "";
                ConsumoProm.textContent = "";
                ConsumoMes.textContent = "";
                ProxVencimiento.textContent = "";
                AdeudoTotal.textContent = "";

                alert("Numero de cuenta invalida o no contiene datos");
                console.error("Error:", response.data.error);
            } else {
                d = response.data

                EstadoServicio.textContent = d.estado_servicio;
                TipoContrato.textContent = d.tipo_contrato;
                Direccion.textContent = d.direccion;
                ConsumoProm.textContent = d.consumo_promedio + " L";
                ConsumoMes.textContent = d.consumo_mes_reciente;
                ProxVencimiento.textContent = d.proximo_vencimiento;
                AdeudoTotal.textContent = "$" + d.adeudo_total;
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Ocurrió un error al realizar la solicitud.");
        });
});


//=============================================================================//
//                           Crear nueva tarjeta                               //
//=============================================================================//
const dFechaVencimiento = document.getElementById('FechaVencimiento');
const dTarjeta = document.getElementById('Tarjeta');

//Validacion de datos
dFechaVencimiento.addEventListener('input', function () {
    let valor = dFechaVencimiento.value.replace(/\D/g, '');
        valor = valor.replace(/(.{2})(?=.)/g, '$1/');
        if (valor.length > 5) {
            valor = valor.substring(0, 5);
        }
        dFechaVencimiento.value = valor;
});

dTarjeta.addEventListener('input', function () {
    let valor = dTarjeta.value.replace(/\D/g, '');
    valor = valor.replace(/(.{4})(?=.)/g, '$1 ');

    if (valor.length > 19) {
        valor = valor.substring(0, 19);
    }
    dTarjeta.value = valor;
});


const formCrearTarjeta = document.getElementById('formCrearTarjetas');
formCrearTarjeta.addEventListener('submit', function (event) {
    event.preventDefault();
    
    const dTitular = document.getElementById('Titular').value;
    const dBanco = document.getElementById('Banco').options[document.getElementById('Banco').selectedIndex].text;
    const dCVV = document.getElementById('CVV').value;

    const datosTarjetas = {
        tarjeta: dTarjeta.value,
        titular: dTitular,
        banco: dBanco,
        vencimiento: dFechaVencimiento.value,
        CVV: dCVV
    };

    console.log('Número de tarjeta:', datosTarjetas.tarjeta, 'Longitud:', datosTarjetas.tarjeta.length);

    axios.post('clientePhp/clienteTarjetas.php', datosTarjetas, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            const d = respuesta.data;
            console.log(respuesta.data);

            if (d.status == 1) {
                traerDatosTarjetas();
                setTimeout(() => {
                    ddlTarjeta.selectedIndex = 0;
                    llenarDatosTarjeta();
                }, 500);

                // Obtener los elementos de los campos por su ID
                document.getElementById('Tarjeta').value = "";
                document.getElementById('Titular').value = "";
                document.getElementById('Banco').selectedIndex = 0;
                document.getElementById('FechaVencimiento').value = "";
                document.getElementById('CVV').value = "";

                formCrearTarjeta.style.display = "none";
                document.getElementById('formPagar').style.display = "block";

                alert('Tarjeta insertada exitosamente');
            } else {
                alert('estado: ' + d.status + '\n message: ' + d.message);
                console.log(d);
            }
        })
        .catch(error => {
            alert('Error:' + error);
        });
});


//=============================================================================//
//                 Cuando pague con la tarjeta seleccionada                    //
//=============================================================================//
const formPagar = document.getElementById('formPagar');
formPagar.addEventListener('submit', function (event) {
    event.preventDefault();
    //Cuando de click al boton pagar
})

//=============================================================================//
//                   Cuando elija una tarjeta en el select                     //
//=============================================================================//
var arTarjeta = [], arTitular = [], arBanco = [], arVencimiento = [];

const PagarPopUp = document.getElementById('PagarPopUp');
const ddlTarjeta = document.getElementById('ddlTarjeta');
var tarjeta = document.getElementById('tarjeta');

//Primero Traer los datos
function traerDatosTarjetas() {
    ddlTarjeta.options.length = 0;

    axios.get('clientePhp/clienteTarjetas.php')
    .then(respuesta => {
        d = respuesta.data;

        if (d.consulta == 0) {
            //Al hacer la consulta a la bd y no encuentra tarjetas hace lo sig:
            const optionNew = document.createElement('option');
            optionNew.value = "Agregue una tarjeta";
            optionNew.textContent = "Agregue una tarjeta";
            ddlTarjeta.appendChild(optionNew);

            tarjeta.style.display = "none";
        }
        else {
            // Vaciar los arrays
            arBanco = [];
            arTarjeta = [];
            arVencimiento = [];
            arTitular = [];
            //insertar datos por medio del forEach
            d.forEach(info => {
                tarjeta.style.display = "block";

                const option = document.createElement('option');
                option.value = info.numeroTarjeta;
                option.textContent = info.numeroTarjeta;
                ddlTarjeta.appendChild(option);

                arTarjeta.push(info.numeroTarjeta);
                arTitular.push(info.titular);
                arBanco.push(info.banco);
                arVencimiento.push(info.fechaVencimiento);
            });
        }
    })
    .catch(error => {
        console.log('Error al obtener los datos de las tarjetas:', error);
    });
}
traerDatosTarjetas();

//Despues llenar los datos de la tarjeta
PagarPopUp.addEventListener('click', function () {
    llenarDatosTarjeta();
});


//Aqui ya mostramos los datos y su seleccion
//Variables
const tBanco = document.getElementById('tBanco');
const tNum = document.getElementById('tNum');
const tFV = document.getElementById('tFV');
const tTitular = document.getElementById('tTitular');


//Cuando haga el select index
ddlTarjeta.addEventListener('change', function () {
    llenarDatosTarjeta();
});

function llenarDatosTarjeta() {

    const tarjetaSeleccionada = ddlTarjeta.options[ddlTarjeta.selectedIndex].text;

    for (let i = 0; i < arTarjeta.length; i++) {
        if (tarjetaSeleccionada == arTarjeta[i]) {
            tBanco.textContent = arBanco[i];
            tNum.textContent = arTarjeta[i];
            tFV.textContent = arVencimiento[i];
            tTitular.textContent = arTitular[i];
        }
    }
};

//=============================================================================//
//               Aparecer y desaparecer submenus de tarjetas                   //
//=============================================================================//
const btnNewTarjeta = document.getElementById('btnNewTarjeta');
const btnOldTarjeta = document.getElementById('btnOldTarjeta');

btnNewTarjeta.addEventListener('click', function () {
    formCrearTarjeta.style.display = "block";
    formPagar.style.display = "none";
});

btnOldTarjeta.addEventListener('click', function () {
    formCrearTarjeta.style.display = "none";
    formPagar.style.display = "block";
});




//=============================================================================//
//                             Eliminar tarjetas                               //
//=============================================================================//
const popup = document.getElementById('popup');
const confirmarBtn = document.getElementById('confirmar');
const cancelarBtn = document.getElementById('cancelar');

function mostrarPopup() {
    if(tNum.textContent == ""){
        alert('No se encontro una tarjeta para eliminar');
        return;
    } else {
        popup.classList.add('show');
    }
    
}

function ocultarPopup() {
    popup.classList.remove('show');
}

confirmarBtn.addEventListener('click', () => {

    axios.post('clientePhp/clienteTarjetas.php', {tnum: tNum.textContent}, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(respuesta => {
            const d = respuesta.data;
            console.log(respuesta.data);

            if (d.status == 1) {
                alert('Tarjeta eliminada');
                traerDatosTarjetas();
                setTimeout(() => {
                    //ddlTarjeta.selectedIndex = ddlTarjeta.options.length - 1;
                    ddlTarjeta.selectedIndex = 0;
                    const selectedText = ddlTarjeta.options[ddlTarjeta.selectedIndex].text;

                    if (/[^0-9]/.test(selectedText)) {
                        tNum.textContent = "";
                        console.log("El texto seleccionado contiene al menos un carácter tipo texto o símbolo.");
                    }
                    llenarDatosTarjeta();
                }, 500);
            } else {
                alert(d.message);
            }
        })
        .catch(error => {
            alert('Error de consulta:' + error);
        });

    ocultarPopup();
});

cancelarBtn.addEventListener('click', () => {
    ocultarPopup();
});

document.getElementById('btnBorrarTarjeta').addEventListener('click', mostrarPopup);



