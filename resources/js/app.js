import './bootstrap';
// Esperamos a que el DOM se haya cargado completamente
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('crear-cuenta');
    if (button) {
        button.addEventListener('click', function () {
            window.location.href = '/register'; // O la ruta que corresponda
        });
    }
});

// esto es el evento del click e boton de crear cuenta ^




