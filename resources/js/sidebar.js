document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggle-sidebar");
    const sidebar = document.getElementById("sidebar");

    if (toggleButton && sidebar) {
        toggleButton.addEventListener("click", function () {
            sidebar.classList.toggle("hidden"); // Alterna la clase "hidden"
        });
    } else {
        console.error("No se encontró el botón de toggle o el menú lateral.");
    }
});
