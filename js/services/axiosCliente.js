//=============CLIENTE=================//
var titular = "";
//===========Detalles de la cuenta============//
const EstadoServicio = document.getElementById('EstadoServicio');
const AdeudoMes = document.getElementById('AdeudoMes');
const TipoContrato = document.getElementById('TipoContrato');
const ProxVencimiento = document.getElementById('ProxVencimiento');
const ConsumoMes = document.getElementById('ConsumoMes');
const ConsumoProm = document.getElementById('ConsumoProm');
const Direccion = document.getElementById('Direccion');
const AdeudoTotal = document.getElementById('adeudoTotalH1');
const MesesAdeudo = document.getElementById('MesesAdeudo');
//===========Datos Recibo===============//
const nom_recibo = document.getElementById('nom_recibo');
const dir_recibo = document.getElementById('dir_recibo');
const cuenta_recibo = document.getElementById('cuenta_recibo');
const mesespagados_recibo = document.getElementById('mesespagados_recibo');
const estado_recibo = document.getElementById('estado_recibo');
const trans_recibo = document.getElementById('trans_recibo');
const fecha_recibo = document.getElementById('fecha_recibo');
const total_recibo = document.getElementById('total_recibo');

const PagarPopUp = document.getElementById('PagarPopUp');
const PagarConQr = document.getElementById('btnQR');

PagarPopUp.classList.add('invalidar-btn');
PagarConQr.classList.add('invalidar-btn');

PagarPopUp.disabled = true;
PagarPopUp.textContent = "NO DISPONIBLE";
PagarConQr.style.display = "none";

//=============================================================================//
//                    Obtener datos al cargar la pagina                        //
//=============================================================================//
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
            // Itera sobre los datos y crea una opción para cada numero de cuenta
            data.forEach(cuenta => {
                const option = document.createElement('option');
                option.value = cuenta;
                option.textContent = cuenta;
                ddlCuentas.appendChild(option);
            });
            mostrarDetallesCuenta();
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
ddlCuentas.addEventListener('change', function () {
    mostrarDetallesCuenta();
});
function mostrarDetallesCuenta(){
    
    const ddlCuentas = document.getElementById('ddlCuentas');
    // Cuenta seleccionada Int
    const cuentaSelec = parseInt(ddlCuentas.options[ddlCuentas.selectedIndex].text);
    cuenta_recibo.textContent = "" + cuentaSelec//Cuenta para rellenar recibo

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
                AdeudoMes.textContent = "";
                TipoContrato.textContent = "";
                Direccion.textContent = "";
                ConsumoProm.textContent = "";
                ConsumoMes.textContent = "";
                ProxVencimiento.textContent = "";
                AdeudoTotal.textContent = "0.00";
                MesesAdeudo.textContent = "";

                alert("Numero de cuenta invalida o no contiene datos");
                console.error("Error:", response.data.error);
            } else {
                d = response.data

                EstadoServicio.textContent = d.estado_servicio;
                AdeudoMes.textContent = d.adeudo_mes;
                TipoContrato.textContent = d.tipo_contrato;
                Direccion.textContent = d.direccion;
                ConsumoProm.textContent = d.consumo_promedio + " L";
                ConsumoMes.textContent = d.consumo_mes_reciente + " L";
                ProxVencimiento.textContent = d.proximo_vencimiento;
                AdeudoTotal.textContent = d.adeudo_total && d.adeudo_total.trim() !== "" ? d.adeudo_total : "0.00";
                MesesAdeudo.textContent = d.meses_adeudo;

                //rellenar recibo
                titular = d.nombre_completo //Para qr

                nom_recibo.textContent = d.nombre_completo;
                dir_recibo.textContent = d.direccion;
                mesespagados_recibo.textContent = d.meses_adeudo;
                fecha_recibo.textContent = new Date().getDate() + "/" + (new Date().getMonth() + 1) + "/" + new Date().getFullYear();
                total_recibo.textContent = d.adeudo_total;

                //Validar btns para pagar
                if (d.estado_servicio == "inactivo") {
                    PagarPopUp.classList.add('invalidar-btn');
                    PagarConQr.classList.add('invalidar-btn');

                    PagarPopUp.disabled = true;
                    PagarPopUp.textContent = "NO DISPONIBLE";
                    PagarConQr.style.display = "none";
                } else {
                    PagarPopUp.classList.remove('invalidar-btn');
                    PagarConQr.classList.remove('invalidar-btn');

                    PagarPopUp.disabled = false;
                    PagarPopUp.textContent = "PAGAR";
                    PagarConQr.style.display = "block";
                }
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Ocurrió un error al realizar la solicitud.");
        });
}
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
//                   Cuando elija una tarjeta en el select                     //
//=============================================================================//
var arTarjeta = [], arTitular = [], arBanco = [], arVencimiento = [];

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
    if (tNum.textContent == "") {
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

    axios.post('clientePhp/clienteTarjetas.php', { tnum: tNum.textContent }, {
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
                        console.log("No hay tarjetas");
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

//=============================================================================//
//                 Cuando pague con la tarjeta seleccionada                    //
//=============================================================================//
const btnPagarFinal = document.getElementById('btnPagarFinal');
const formPagar = document.getElementById('formPagar');
formPagar.addEventListener('submit', function (event) {
    event.preventDefault();
    
    const selectedText = ddlTarjeta.options[ddlTarjeta.selectedIndex].text; //Tarjeta string
    const cuentaSelec = parseInt(ddlCuentas.options[ddlCuentas.selectedIndex].text);//Cuneta int

    let totalReciboFloat = parseFloat(AdeudoTotal.textContent);//Total float
    let mesesPagadosInt = parseInt(MesesAdeudo.textContent); //Meses pagados


    

    if (/^[0-9\s]*$/.test(selectedText)) {
        insertarPago(totalReciboFloat, mesesPagadosInt, cuentaSelec, selectedText);
    } else {
        tNum.textContent = "";
        alert("No hay tarjetas para pagar, porfavor agregue una");
    }

})


//Funcion para pagar
function insertarPago(monto, mpagos, cuenta, tarjeta) {
    // Datos ficticios de prueba
    const datosPago = {
        monto: monto,  //  float
        meses_pagados: mpagos,  // int
        fk_cuenta: cuenta,  // int
        fk_tarjeta: tarjeta  // varchar
    };

    // Enviar los datos al archivo PHP
    axios.post('clientePhp/Pagos.php', datosPago, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(respuesta => {
        const data = respuesta.data;
        if (data.status === 1) {

            estado_recibo.textContent = "Liquidado";
            trans_recibo.textContent = data.transaccion;
            mostrarDetallesCuenta();

            const reciboElement = document.querySelector('.recibo');
            reciboElement.style.display = "block";
            // Obtén las dimensiones del recibo
            const contentWidth = reciboElement.offsetWidth;
            const contentHeight = reciboElement.offsetHeight;
    
            // Configuración para ajustar el tamaño exacto del recibo
            const options = {
                margin: 0,
                filename: 'recibo-pago.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 4, // Calidad
                    useCORS: true // Permitir cargar recursos de manera segura
                },
                jsPDF: {
                    unit: 'px', // Usar píxeles
                    format: [contentWidth, contentHeight], // Tamaño dinámico basado en el recibo
                    orientation: 'portrait'
                }
            };
    
            // Genera y descarga el PDF
            html2pdf().set(options).from(reciboElement).save();
            alert('Pago registrado exitosamente');
            setTimeout(() => {
                reciboElement.style.display = "none";
            }, 1000);

        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al realizar la solicitud:', error);
        alert('Error al enviar la solicitud');
    });
}

