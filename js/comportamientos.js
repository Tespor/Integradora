        // Función para cargar usuarios y cuentas
        function cargarUsuariosYCuentas() {
          fetch('mostrar_datos.php')
              .then(response => response.json())
              .then(data => {
                  const selectDDL = document.getElementById('selectDDL');
                  selectDDL.innerHTML = ''; // Limpia cualquier opción anterior
      
                  // Llena el primer select con los nombres de usuario
                  data.usernames.forEach(username => {
                      const option = document.createElement('option');
                      option.value = username;
                      option.textContent = username;
                      selectDDL.appendChild(option);
                  });
      
                  // Almacena las cuentas por usuario en una variable global
                  window.cuentasPorUsuario = data.cuentasPorUsuario;
              })
              .catch(error => console.error('Error al cargar usuarios y cuentas:', error));
      }
      
      // Manejador de doble clic
      const selectElement = document.getElementById('selectDDL');
      selectElement.addEventListener('dblclick', function(event) {
          const selectedOption = event.target;
      
          // Verifica si el target es una opción
          if (selectedOption.tagName === 'OPTION') {
              const username = selectedOption.value;
              alert(`Seleccionaste: ${username}`);
      
              // Llama a cargar las cuentas en el segundo select
              cargarCuentas(username);
          }
      });
      
      // Función para cargar las cuentas en el segundo select
      function cargarCuentas(username) {
          const cuentaSelect = document.getElementById('cuentaDDL');
          cuentaSelect.innerHTML = ''; // Limpia opciones anteriores
      
          // Verifica si el usuario tiene cuentas asignadas
          const cuentas = window.cuentasPorUsuario[username] || [];
          
          if (cuentas.length === 0) {
              const option = document.createElement('option');
              option.textContent = 'Sin cuentas disponibles';
              cuentaSelect.appendChild(option);
          } else {
              cuentas.forEach(idCuenta => {
                  const option = document.createElement('option');
                  option.value = idCuenta;
                  option.textContent = `Cuenta ID: ${idCuenta}`;
                  cuentaSelect.appendChild(option);
              });
          }
      }
      
      // Cargar usuarios y cuentas al cargar la página
      window.onload = cargarUsuariosYCuentas;
      