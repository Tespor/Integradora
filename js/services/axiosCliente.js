//=============CLIENTE=================//
const EstadoServicio = document.getElementById('EstadoServicio');
const TipoContrato = document.getElementById('TipoContrato');
const ProxVencimiento = document.getElementById('ProxVencimiento');
const ConsumoMes = document.getElementById('ConsumoMes');
const ConsumoProm = document.getElementById('ConsumoProm');
const Direccion = document.getElementById('Direccion');

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



//========Cuando el select cambie que muestre los datos============//
ddlCuentas.addEventListener('change', function() {
    // Obtiene el texto de la opción seleccionada
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
                console.log("Estado del servicio:", response.data.estado_servicio);
                console.log("Tipo de contrato:", response.data.tipo_contrato);
                console.log("Dirección:", response.data.direccion);
                console.log("Consumo promedio:", response.data.consumo_promedio);
                console.log("Consumo del mes reciente:", response.data.consumo_mes_reciente);
                console.log("Próximo vencimiento:", response.data.proximo_vencimiento);

                EstadoServicio.textContent = response.data.estado_servicio;
                TipoContrato.textContent = response.data.tipo_contrato;
                Direccion.textContent = response.data.direccion;
                ConsumoProm.textContent = response.data.consumo_promedio + " L";
                ConsumoMes.textContent = response.data.consumo_mes_reciente;
                ProxVencimiento.textContent = response.data.proximo_vencimiento;
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert("Ocurrió un error al realizar la solicitud.");
        });
});

function llenarDatosDeCuenta(){

}