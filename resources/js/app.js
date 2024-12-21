import './bootstrap';

// Evento para el botón "crear cuenta"
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('crear-cuenta');
    if (button) {
        button.addEventListener('click', function () {
            window.location.href = '/register'; // Redirige a la ruta de registro
        });
    }
});

// ANIMACIÓN DE COPOS DE NIEVE CAYENDO
document.addEventListener("DOMContentLoaded", function () {
    // Crear el contenedor para los copos de nieve
    const snowContainer = document.createElement("div");
    snowContainer.classList.add("snow-container");
    document.body.appendChild(snowContainer);

    // Función para crear un copo de nieve
    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.classList.add("snowflake");

        // Propiedades aleatorias del copo
        snowflake.style.left = Math.random() * 100 + "vw"; // Posición horizontal aleatoria
        snowflake.style.width = snowflake.style.height = Math.random() * 5 + 2 + "px"; // Tamaño aleatorio entre 2px y 7px
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Duración de la animación entre 2 y 5 segundos

        // Añadir el copo al contenedor
        snowContainer.appendChild(snowflake);

        // Eliminar el copo después de 5 segundos
        setTimeout(() => {
            snowflake.remove();
        }, 5000);
    }

    // Crear un copo de nieve cada 200ms
    setInterval(createSnowflake, 200);
});


// Abrir el modal al hacer clic en el botón "CREAR AVISO" ⚠️
document.addEventListener('DOMContentLoaded', function () {
    const btnAbrirModal = document.getElementById('btn-registrar-incidencia');
    const modal = document.getElementById('modal-registrar-incidencia');
    const btnCerrarModal = document.getElementById('cerrar-modal');

    if (btnAbrirModal) {
        btnAbrirModal.addEventListener('click', function () {
            modal.classList.remove('hidden');
        });
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

    // Cerrar el modal si se hace clic fuera de su contenido
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

/// BOTON DE EDITAR PERFIL EN EL PERFIL DE USUARIO

document.getElementById('btnEditarPerfil').addEventListener('click', function () {
    document.getElementById('modalEditarPerfil').classList.remove('hidden'); // Mostrar el modal
});

document.getElementById('btnCerrarModal').addEventListener('click', function () {
    document.getElementById('modalEditarPerfil').classList.add('hidden'); // Ocultar el modal
});

// Cerrar el modal al hacer clic fuera de él (opcional)
document.getElementById('modalEditarPerfil').addEventListener('click', function (e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// MODAL ANIMALCIÓN METALICA BRILLO

let shineTimeouts = [];

// Función para aplicar el brillo de forma orgánica
function startOrganicShine(modalContent) {
    const applyShine = () => {
        modalContent.classList.add('modal-shine');
        shineTimeouts.push(
            setTimeout(() => {
                modalContent.classList.remove('modal-shine');

                // Cambiar dirección del brillo
                const currentDirection = modalContent.style.animationDirection || 'normal';
                modalContent.style.animationDirection = currentDirection === 'normal' ? 'reverse' : 'normal';

                // Volver a aplicar el brillo tras una pausa aleatoria
                shineTimeouts.push(setTimeout(applyShine, Math.random() * 2000 + 1000)); // Pausa de 1 a 3 segundos
            }, 1000) // Duración del brillo
        );
    };

    applyShine(); // Iniciar el brillo orgánico
}

// Abrir el modal y activar la animación
document.getElementById('btnEditarPerfil').addEventListener('click', function () {
    const modal = document.getElementById('modalEditarPerfil');
    const modalContent = modal.querySelector('.modal-content'); // Contenedor que brillará

    modal.classList.remove('hidden'); // Mostrar el modal
    startOrganicShine(modalContent); // Iniciar el brillo orgánico
});

// Cerrar el modal
document.getElementById('btnCerrarModal').addEventListener('click', function () {
    const modal = document.getElementById('modalEditarPerfil');
    const modalContent = modal.querySelector('.modal-content');

    modal.classList.add('hidden'); // Ocultar el modal

    // Limpiar todas las animaciones en curso
    shineTimeouts.forEach(clearTimeout);
    shineTimeouts = [];
    modalContent.classList.remove('modal-shine');
});

// Cerrar el modal si el usuario hace clic fuera del contenido
document.getElementById('modalEditarPerfil').addEventListener('click', function (e) {
    if (e.target === this) {
        const modalContent = this.querySelector('.modal-content');

        this.classList.add('hidden'); // Ocultar el modal

        // Limpiar todas las animaciones en curso
        shineTimeouts.forEach(clearTimeout);
        shineTimeouts = [];
        modalContent.classList.remove('modal-shine');
    }
});
