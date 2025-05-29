document.addEventListener("DOMContentLoaded", () => {
    const bot = new window.RiveScript();

    bot.stream(`
+ hola
+ buenas
+ hey
- ¡Hola! ¿En qué puedo ayudarte?

+ como crear incidencia
+ crear incidencia
+ nueva incidencia
+ crear ticket
- Para crear una incidencia, haz clic en el botón "CREAR TICKET" arriba a la derecha.

+ donde estan mis incidencias
+ ver incidencias
+ ver tickets
- Puedes verlas en el menú lateral, sección "Incidencias".

+ cerrar sesion
+ como cerrar sesion
+ salir
- Puedes cerrar sesión desde el menú arriba a la derecha, junto a tu nombre.

+ ayuda
+ necesito ayuda
+ que puedes hacer
+ como funciona esto
- Estoy aquí para ayudarte con incidencias, tickets o navegación básica.

+ quien eres
- Soy un asistente virtual para ayudarte con la app de incidencias.

+ que es una incidencia
- Es un problema técnico que puedes reportar a soporte desde el botón "CREAR TICKET".

+ soporte
+ contacto
- Puedes contactar con soporte escribiendo a soporte@empresa.com.

+ gracias
+ muchas gracias
+ ok
- ¡De nada! 😊 Estoy para ayudarte.

+ *
- No entendí eso. Intenta preguntarme de otra forma.
    `);

    bot.sortReplies();

    const chatlog = document.getElementById('chatlog');
    const input = document.getElementById('chatInput');
    const minimizarBtn = document.getElementById('minimizarChat');
    const sendBtn = document.getElementById('chatSendBtn'); // 👈 asegúrate de que este botón existe

    minimizarBtn.addEventListener('click', () => {
        const collapsed = chatlog.style.display === 'none';
        chatlog.style.display = collapsed ? 'block' : 'none';
        input.parentElement.style.display = collapsed ? 'flex' : 'none';
        minimizarBtn.textContent = collapsed ? '–' : '+';
    });

    window.sendMessage = async function () {
        const raw = input.value;
        const text = raw
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^\x00-\x7F]/g, "") // quita emojis
            .replace(/[^\w\s]/gi, "")    // limpia cosas raras
            .trim()
            .toLowerCase();

        if (!text) return;

        chatlog.innerHTML += `<div class="text-right text-blue-700">${raw}</div>`;
        const reply = await bot.reply("local-user", text);
        chatlog.innerHTML += `<div class="text-gray-700">${reply}</div>`;
        chatlog.scrollTop = chatlog.scrollHeight;
        input.value = '';
    };

    if (sendBtn) {
        sendBtn.addEventListener('click', window.sendMessage);
    }
});
