// Importa el archivo de configuración inicial de Laravel que incluye Bootstrap y otras configuraciones esenciales.
import './bootstrap';

// ** Evento para el botón "Crear Cuenta" **
document.addEventListener('DOMContentLoaded', function () {
    const button = document.getElementById('crear-cuenta');
    if (button) {
        button.addEventListener('click', function () {
            window.location.href = '/register'; // Redirige a la ruta '/register'.
        });
    }
});

// ** ANIMACIÓN NIEVE CAYENDO  **
document.addEventListener("DOMContentLoaded", function () {
    const snowContainer = document.createElement("div");
    snowContainer.classList.add("snow-container");
    document.body.appendChild(snowContainer);

    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.classList.add("snowflake");
        snowflake.style.left = Math.random() * 100 + "vw";
        snowflake.style.width = snowflake.style.height = Math.random() * 5 + 2 + "px";
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s";
        snowContainer.appendChild(snowflake);
        setTimeout(() => snowflake.remove(), 5000);
    }

    setInterval(createSnowflake, 200);
});

// ** Abrir modal "CREAR TICKET" **
document.addEventListener('DOMContentLoaded', function () {
    const btnAbrirModal = document.getElementById('btn-registrar-incidencia');
    const modal = document.getElementById('modal-registrar-incidencia');
    const btnCerrarModal = document.getElementById('cerrar-modal');

    if (btnAbrirModal) {
        btnAbrirModal.addEventListener('click', () => modal?.classList.remove('hidden'));
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener('click', () => modal?.classList.add('hidden'));
    }

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.add('hidden');
        });
    }
});

// ** Botón "Editar Perfil" en el perfil de usuario **
document.addEventListener('DOMContentLoaded', function () {
    const btnEditarPerfil = document.getElementById('btnEditarPerfil');
    const modalEditarPerfil = document.getElementById('modalEditarPerfil');
    const btnCerrarModal = document.getElementById('btnCerrarModal');

    if (btnEditarPerfil) {
        btnEditarPerfil.addEventListener('click', () => modalEditarPerfil?.classList.remove('hidden'));
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener('click', () => modalEditarPerfil?.classList.add('hidden'));
    }

    if (modalEditarPerfil) {
        modalEditarPerfil.addEventListener('click', function (e) {
            if (e.target === modalEditarPerfil) modalEditarPerfil.classList.add('hidden');
        });
    }
});

// ** Brillo metálico del modal editar usuario **
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalEditarPerfil');
    const modalContent = modal?.querySelector('.modal-content');
    const btnCerrarModal = document.getElementById('btnCerrarModal');
    let shineTimeouts = [];

    function startOrganicShine() {
        const applyShine = () => {
            modalContent?.classList.add('modal-shine');
            shineTimeouts.push(
                setTimeout(() => {
                    modalContent?.classList.remove('modal-shine');
                    const direction = modalContent?.style.animationDirection || 'normal';
                    modalContent.style.animationDirection = direction === 'normal' ? 'reverse' : 'normal';
                    shineTimeouts.push(setTimeout(applyShine, Math.random() * 2000 + 1000));
                }, 1000)
            );
        };
        applyShine();
    }

    if (modal) {
        document.getElementById('btnEditarPerfil')?.addEventListener('click', function () {
            modal.classList.remove('hidden');
            startOrganicShine();
        });

        btnCerrarModal?.addEventListener('click', function () {
            modal.classList.add('hidden');
            shineTimeouts.forEach(clearTimeout);
            shineTimeouts = [];
            modalContent?.classList.remove('modal-shine');
        });

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

// ** Modal para visualizar archivo adjunto **
document.addEventListener('DOMContentLoaded', () => {
    const archivoAdjunto = document.getElementById('archivoAdjunto');
    const modalArchivo = document.getElementById('modalArchivo');
    const cerrarModal = document.getElementById('cerrarModal');

    archivoAdjunto?.addEventListener('click', () => modalArchivo?.classList.remove('hidden'));
    cerrarModal?.addEventListener('click', () => modalArchivo?.classList.add('hidden'));

    modalArchivo?.addEventListener('click', (e) => {
        if (e.target === modalArchivo) {
            modalArchivo.classList.add('hidden');
        }
    });
});

// ** MODAL PARA MENSAJE ANTES DE METER INCIDENCIAS **

document.addEventListener("DOMContentLoaded", function () {
    // Revisar si el modal debe mostrarse
    const modal = document.getElementById("modalNotificacion");
    if (!modal.dataset.ocultarModal) {
        // Mostrar el modal automáticamente al cargar la página
        modal.classList.remove("hidden");

        // Cerrar el modal al hacer clic en el botón "Entendido"
        const cerrarModal = document.getElementById("cerrarModalNotificacion");
        cerrarModal.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    }
});

//**ANIMACIÓN DE SEMICIRCULO**//

document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('semicircleChart');
    if (!canvas) {
        console.error("Canvas no encontrado");
        return;
    }

    const ctx = canvas.getContext('2d');

    const labels = @json(array_keys($incidenciasPorCategoria->toArray()));
    const dataValues = @json(array_column($incidenciasPorCategoria->toArray(), 'count'));

    const data = {
        labels: labels,
        datasets: [{
            label: 'Incidencias por Categoría',
            data: dataValues,
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6f42c1', '#e83e8c', '#fd7e14'],
        }]
    };

    const options = {
        type: 'doughnut',
        data: data,
        options: {
            rotation: -90,
            circumference: 180,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                },
            },
        },
    };

    try {
        new Chart(ctx, options);
    } catch (error) {
        console.error("Error al crear el gráfico:", error);
    }
});
