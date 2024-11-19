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
ddlCuentas.addEventListener('change', function() {
    // Texto de la opción seleccionada
    const cuentaSelec = parseInt(ddlCuentas.options[ddlCuentas.selectedIndex].text);

    //Mostrar datos de la cuenta
        axios.post('clientePhp/datosCuenta.php', {idCuenta: cuentaSelec}, 
        {
            headers: {
                'Content-Type': 'application/json' // Aseguramos que sea un JSON
            }
        })
        .then(response => {
            console.log(response.data);

            if (response.data.error) {
                console.error("Error:", response.data.error);
            } else {
                d = response.data

                EstadoServicio.textContent = d.estado_servicio;
                TipoContrato.textContent = d.tipo_contrato;
                Direccion.textContent = d.direccion;
                ConsumoProm.textContent = d.consumo_promedio + " L";
                ConsumoMes.textContent = d.consumo_mes_reciente;
                ProxVencimiento.textContent = d.proximo_vencimiento;
                AdeudoTotal.textContent = d.adeudo_total;
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Ocurrió un error al realizar la solicitud.");
        });
});

function llenarDatosDeCuenta(){

}