const fondoPop = document.getElementById('fondoPop');

const openPopoverButtons = document.querySelectorAll('[popovertarget]');
const closePopoverButtons = document.querySelectorAll('.close-popover');

openPopoverButtons.forEach(input => {
  input.addEventListener('click', () => {
    const targetId = input.getAttribute('popovertarget');
    const popover = document.getElementById(targetId);
    fondoPop.style.display = "block"
    popover.showPopover();
  });
});

// Cerrar popover y fondo negro
closePopoverButtons.forEach(input => {
  input.addEventListener('click', () => {
    const popover = input.closest('[popover]'); // Encuentra el popover relacionado

    // Ocultar el popover y el fondo negro
    popover.hidePopover();
    fondoPop.style.display = "none"
  });
});

// Cerrar al hacer clic en el fondo negro
fondoPop.addEventListener('click', () => {
  const popovers = document.querySelectorAll('[popover]');

  // Oculta todos los popovers y quita fondo
  popovers.forEach(popover => popover.hidePopover());
  fondoPop.style.display = "none"
});
