

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

// esto es el evento del click de boton de crear cuenta 🔼🔼🔼


//ANIMACIÓN DE COPOS DE NIEVE CAYENDO ⬇️⬇️
import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
    // Crear el contenedor de nieve al final del body
    const snowContainer = document.createElement("div");
    snowContainer.classList.add("snow-container");
    document.body.appendChild(snowContainer);

    // Función para generar copos de nieve
    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.classList.add("snowflake");

        // Posición y propiedades aleatorias
        snowflake.style.left = Math.random() * 100 + "vw"; // Posición horizontal aleatoria
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Duración aleatoria entre 2 y 5 segundos
        snowflake.style.width = snowflake.style.height = Math.random() * 5 + 2 + "px"; // Tamaño aleatorio
        snowflake.style.opacity = Math.random() * 0.5 + 0.3; // Opacidad aleatoria

        snowContainer.appendChild(snowflake);

        // Elimina el copo después de la animación
        setTimeout(() => {
            snowflake.remove();
        }, 5000); // Tiempo máximo de vida
    }

    // Crear un copo de nieve cada 200ms
    setInterval(createSnowflake, 200);
});
