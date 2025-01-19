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


// **************************************************** \\
// ** MODAL PARA MENSAJE ANTES DE METER INCIDENCIAS (ENTENDIDO Y NO MOSTRAR MAS) **

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modalNotificacion");
    const btnCrearTicket = document.getElementById("btn-registrar-incidencia");
    const btnCerrarModal = document.getElementById("cerrarModalNotificacion");
    const formNoMostrarMas = document.getElementById("formNoMostrarMas");

    console.log("Modal:", modal);
    console.log("Botón 'Crear Ticket':", btnCrearTicket);

    if (!modal || !btnCrearTicket || !btnCerrarModal || !formNoMostrarMas) {
        console.error("Error: Elementos esenciales no encontrados en el DOM.");
        return;
    }

    // Mostrar el modal solo cuando se hace clic en el botón "Registrar nuevo ticket"
    btnCrearTicket.addEventListener("click", function () {
        console.log("Modal mostrado al hacer clic en 'Registrar nuevo ticket'.");
        console.log("Estado de localStorage (formNoMostrarMas):", localStorage.getItem("formNoMostrarMas"));
        if (localStorage.getItem("formNoMostrarMas") === null) {
            modal.classList.remove("hidden");
            console.log("Clase 'hidden' removida del modal.");
        } else {
            console.log("El modal no se muestra porque 'No mostrar más' está activo.");
        }
    });

    // Botón "Entendido" para cerrar el modal
    btnCerrarModal.addEventListener("click", function () {
        modal.classList.add("hidden");
        console.log("Modal cerrado con el botón 'Entendido'.");
    });

    // Botón "No mostrar más" para cerrar y enviar la solicitud al servidor
    formNoMostrarMas.addEventListener("submit", function (e) {
        e.preventDefault();
        console.log("Formulario 'No mostrar más' enviado.");
        localStorage.setItem("formNoMostrarMas", "true");
        console.log("Estado de localStorage actualizado: 'formNoMostrarMas' = true");
        setTimeout(function () {
            localStorage.removeItem("formNoMostrarMas");
            console.log("'formNoMostrarMas' eliminado del localStorage después del tiempo establecido.");
        }, 10000); // Ajusta este tiempo según tus necesidades
        modal.classList.add("hidden");
        console.log("Modal ocultado tras enviar el formulario.");
    });
});


//**ANIMACIÓN DE SEMICIRCULO**//

document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('semicircleChart');
    if (!canvas) {
        console.error("Canvas no encontrado");
        return;
    }

    const ctx = canvas.getContext('2d');

    // Obtener los datos desde el objeto global
    const labels = window.chartData.labels || [];
    const dataValues = window.chartData.dataValues || [];

    console.log("Labels:", labels);
    console.log("Data Values:", dataValues);

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
            rotation: -90, // Inicia desde -90 grados
            circumference: 180, // Muestra solo la mitad del círculo (180 grados)
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const dataset = tooltipItem.dataset;
                            const dataIndex = tooltipItem.dataIndex;
                            const value = dataset.data[dataIndex];
                            const total = dataset.data.reduce((acc, current) => acc + current, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${value} incidencias (${percentage}%)`;
                        }
                    }
                }
            },
        },
    };

    try {
        new Chart(ctx, options);
        console.log("Gráfico creado exitosamente");
    } catch (error) {
        console.error("Error al crear el gráfico:", error);
    }
});
