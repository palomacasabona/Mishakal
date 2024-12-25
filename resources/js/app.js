// Importa el archivo de configuración inicial de Laravel que incluye Bootstrap y otras configuraciones esenciales.
import './bootstrap';

// ** Evento para el botón "Crear Cuenta" **
document.addEventListener('DOMContentLoaded', function () {
    // Busca el botón con el ID "crear-cuenta".
    const button = document.getElementById('crear-cuenta');
    if (button) {
        // Si el botón existe, agrega un evento para redirigir al usuario a la página de registro.
        button.addEventListener('click', function () {
            window.location.href = '/register'; // Redirige a la ruta '/register'.
        });
    }
});

// ** Animación de copos de nieve cayendo **
document.addEventListener("DOMContentLoaded", function () {
    // Crea un contenedor para los copos de nieve y lo agrega al cuerpo del documento.
    const snowContainer = document.createElement("div");
    snowContainer.classList.add("snow-container");
    document.body.appendChild(snowContainer);

    // Función que crea un único copo de nieve.
    function createSnowflake() {
        // Crea un elemento div que representará un copo de nieve.
        const snowflake = document.createElement("div");
        snowflake.classList.add("snowflake");

        // Asigna propiedades aleatorias: posición horizontal, tamaño y duración de animación.
        snowflake.style.left = Math.random() * 100 + "vw"; // Posición horizontal entre 0 y 100% del ancho de la ventana.
        snowflake.style.width = snowflake.style.height = Math.random() * 5 + 2 + "px"; // Tamaño entre 2px y 7px.
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Duración de 2 a 5 segundos.

        // Agrega el copo de nieve al contenedor y lo elimina tras 5 segundos.
        snowContainer.appendChild(snowflake);
        setTimeout(() => snowflake.remove(), 5000);
    }

    // Llama a la función `createSnowflake` cada 200 ms para generar copos de manera continua.
    setInterval(createSnowflake, 200);
});

// ** Abrir modal "Crear Aviso" **
document.addEventListener('DOMContentLoaded', function () {
    // Busca los elementos relevantes para el modal: botón para abrir, modal en sí y botón para cerrar.
    const btnAbrirModal = document.getElementById('btn-registrar-incidencia');
    const modal = document.getElementById('modal-registrar-incidencia');
    const btnCerrarModal = document.getElementById('cerrar-modal');

    if (btnAbrirModal) {
        // Muestra el modal cuando se hace clic en el botón "CREAR AVISO".
        btnAbrirModal.addEventListener('click', () => modal.classList.remove('hidden'));
    }

    if (btnCerrarModal) {
        // Oculta el modal al hacer clic en el botón de cerrar.
        btnCerrarModal.addEventListener('click', () => modal.classList.add('hidden'));
    }

    if (modal) {
        // Si se hace clic fuera del contenido del modal, también se cierra.
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.add('hidden');
        });
    }
});

// ** Botón "Editar Perfil" en el perfil de usuario **
document.addEventListener('DOMContentLoaded', function () {
    // Busca los elementos para el modal de editar perfil.
    const btnEditarPerfil = document.getElementById('btnEditarPerfil');
    const modalEditarPerfil = document.getElementById('modalEditarPerfil');
    const btnCerrarModal = document.getElementById('btnCerrarModal');

    if (btnEditarPerfil) {
        // Muestra el modal de editar perfil cuando se hace clic en el botón "Editar Perfil".
        btnEditarPerfil.addEventListener('click', () => modalEditarPerfil.classList.remove('hidden'));
    }

    if (btnCerrarModal) {
        // Oculta el modal al hacer clic en el botón de cerrar.
        btnCerrarModal.addEventListener('click', () => modalEditarPerfil.classList.add('hidden'));
    }

    if (modalEditarPerfil) {
        // Si se hace clic fuera del contenido del modal, también se cierra.
        modalEditarPerfil.addEventListener('click', function (e) {
            if (e.target === modalEditarPerfil) modalEditarPerfil.classList.add('hidden');
        });
    }
});

// ** Brillo metálico del modal **
document.addEventListener('DOMContentLoaded', function () {
    // Busca los elementos relevantes para la animación del brillo metálico.
    const modal = document.getElementById('modalEditarPerfil');
    const modalContent = modal?.querySelector('.modal-content');
    const btnCerrarModal = document.getElementById('btnCerrarModal');
    let shineTimeouts = []; // Almacena los IDs de los timeouts para cancelarlos si es necesario.

    // Función para iniciar el brillo orgánico en el modal.
    function startOrganicShine() {
        const applyShine = () => {
            // Agrega la clase que activa el brillo metálico.
            modalContent?.classList.add('modal-shine');
            shineTimeouts.push(
                setTimeout(() => {
                    // Remueve la clase del brillo después de 1 segundo.
                    modalContent?.classList.remove('modal-shine');

                    // Alterna la dirección de la animación (normal o reverse).
                    const direction = modalContent?.style.animationDirection || 'normal';
                    modalContent.style.animationDirection = direction === 'normal' ? 'reverse' : 'normal';

                    // Repite el proceso con una pausa aleatoria entre 1 y 3 segundos.
                    shineTimeouts.push(setTimeout(applyShine, Math.random() * 2000 + 1000));
                }, 1000)
            );
        };

        applyShine(); // Llama inicialmente a la función.
    }

    if (modal) {
        // Inicia el brillo metálico cuando se abre el modal.
        document.getElementById('btnEditarPerfil')?.addEventListener('click', function () {
            modal.classList.remove('hidden');
            startOrganicShine();
        });

        // Detiene el brillo y cierra el modal al hacer clic en el botón de cerrar.
        btnCerrarModal?.addEventListener('click', function () {
            modal.classList.add('hidden');
            shineTimeouts.forEach(clearTimeout); // Cancela cualquier animación pendiente.
            shineTimeouts = [];
            modalContent?.classList.remove('modal-shine');
        });

        // Detiene el brillo y cierra el modal si se hace clic fuera del contenido.
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                shineTimeouts.forEach(clearTimeout);
                shineTimeouts = [];
                modalContent?.classList.remove('modal-shine');
            }
        });
    }
});
