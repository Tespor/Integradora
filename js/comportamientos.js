const selectElement = document.getElementById('selectDDL');

// Agregar un listener para el doble clic en el select
selectElement.addEventListener('dblclick', function(event) {
  const selectedOption = event.target;

  // Verifica si el target es una opción
  if (selectedOption.tagName === 'OPTION') {
    alert(`Seleccionaste: ${selectedOption.textContent}`);
  }
});
