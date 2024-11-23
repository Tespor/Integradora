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

//========Registrar cuenta============//
document.getElementById('formCuenta').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

    // Capturar los valores del formulario
    const tipoContrato = document.getElementById('ddlTipoContrato').value;
    const direccion = document.getElementById('cardHolder').value;
    const estadoServicio = document.querySelector('input[name="grupo"]:checked').value;

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


//========Cuando el select cambie que muestre los datos============//
//var para borrar priper option
var x = true;
ddlCuentas.addEventListener('change', function() {
    // Texto de la opción seleccionada
    const cuentaSelec = parseInt(ddlCuentas.options[ddlCuentas.selectedIndex].text);
    if(x){
        ddlCuentas.remove(0);
        x = false;
    }
    //Mostrar datos de la cuenta
        axios.post('clientePhp/datosCuenta.php', {idCuenta: cuentaSelec}, 
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
const formCrearTarjeta = document.getElementById('formCrearTarjetas');
formCrearTarjeta.addEventListener('submit', function(event){
    event.preventDefault();

    const dTarjeta = document.getElementById('Tarjeta').value;
    const dTitular = document.getElementById('Titular').value;
    const dBanco = document.getElementById('Banco').options[document.getElementById('Banco').selectedIndex].text;
    const dFechaVencimiento = document.getElementById('FechaVencimiento').value;
    const dCVV = document.getElementById('CVV').value;

 
    const datosTarjetas = {
        tarjeta: dTarjeta,
        titular: dTitular,
        banco: dBanco,
        vencimiento: dFechaVencimiento,
        CVV: dCVV
    };

    axios.post('clientePhp/clienteTarjetas.php', datosTarjetas, {
        headers: {
            'Content-Type': 'application/json' 
        }
    })
    .then(respuesta =>{
        const d = respuesta.data;
        console.log(respuesta.data);

        if (d.status == 1){
            // Obtener los elementos de los campos por su ID
            document.getElementById('Tarjeta').value = "";
            document.getElementById('Titular').value = ""; 
            document.getElementById('Banco').selectedIndex = 0; 
            document.getElementById('FechaVencimiento').value = ""; 
            document.getElementById('CVV').value = "";
            
            document.getElementById('btnNewTarjeta').style.display = "none";
            document.getElementById('btnOldTarjeta').style.display = "block";

            alert('Tarjeta insertada exitosamente');
        } else {
            alert('Tarjeta  no insertada');
        }
    })
    .catch(error =>{
        alert('Error:' + error);
    });
});


//=============================================================================//
//                 Cuando pague con la tarjeta seleccionada                    //
//=============================================================================//
const formPagar = document.getElementById('formPagar');
formPagar.addEventListener('submit', function(event){
    event.preventDefault();
    //Cuando de click al boton pagar
})

//=============================================================================//
//                   Cuando eliga una tarjeta en el select                     //
//=============================================================================//
var arTarjeta = [], arTitular = [], arBanco = [], arVencimiento = [];

const PagarPopUp = document.getElementById('PagarPopUp');
const ddlTarjeta = document.getElementById('ddlTarjeta');


axios.get('clientePhp/clienteTarjetas.php')
    .then(respuesta => {
        d = respuesta.data; 
        console.log(d)

        if(d.consulta == 0){
            const optionNew = document.createElement('option');
            optionNew.value = "No existen tarjetas";
            optionNew.textContent = "No existen tarjetas";
            ddlTarjeta.appendChild(optionNew);
        }
        else{
            d.forEach(info => {
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


//=============================================================================//
//               Aparecer y desaparecer submenus de tarjetas                   //
//=============================================================================//
const btnNewTarjeta = document.getElementById('btnNewTarjeta');
const btnOldTarjeta = document.getElementById('btnOldTarjeta');

btnNewTarjeta.addEventListener('click', function() {
    formCrearTarjeta.style.display = "block";
    formPagar.style.display = "none";
});

btnOldTarjeta.addEventListener('click', function() {
    formCrearTarjeta.style.display = "none";
    formPagar.style.display = "block";
});


