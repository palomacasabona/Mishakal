<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplicación de Incidencias')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon_io/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- VITE (CSS y JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/sidebar.js'])


    <!-- SIDEBAR JS /SCRIPT  -->
    <script src="{{ asset('js/app.js') }}" defer></script><!-- ESTA LINEA NO SIRVE-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

</head>
<body class="bg-gray-100">
<!--  ANIMACIÓN DE COPOS DE NIEVE CAYENDO ⬇️⬇️ -->

<div class="snow-container"></div>

<!--  ANIMACIÓN DE COPOS DE NIEVE CAYENDO ⬆⬆️⬆️-->

<!-- Barra de navegación superior -->

<header class="flex items-center justify-between p-4 text-white shadow-md w-screen" style="background-color: #007bff;">
    <div class="flex items-center">
        <div class="mr-4">
            <!-- LOGO  -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 sm:h-12 md:h-12 w-auto">
        </div>
        <h1 class="text-lg sm:text-xl font-bold">MISHAKAL</h1>
    </div>
    <div class="flex items-center space-x-4">
        <!----------------------------------------------------------------------------->
        <!--------------------------------- BOTONES ---------------------------------->

        <!-- Formulario de BUSCAR -->
        <form method="GET" action="{{ route('incidencias.index') }}" class="flex items-center space-x-2">
            <input
                type="text"
                name="search"
                placeholder="Buscar por ID o Título"
                value="{{ request('search') }}"
                class="border rounded-md px-4 py-2 text-black"
            />
            <!-- Botón con Lupa -->
            <button
                type="submit"
                class="text-2xl"
                style="color: #ffffff; background-color: transparent; border: none;"
            >
                <i class="fas fa-search"></i>
            </button>
        </form>
        <!-- BARRA CON LOS ICONOS NAVBAR -->
        <nav>

            <ul class="flex items-center space-x-6">
                @if(Auth::check())
                    <!-- Usuario autenticado -->
                    <li class="text-white text-lg flex items-center space-x-2">
                        <span>Bienvenido, {{ Auth::user()->nombre }}</span>
                        <!-- Insignia de Admin -->
                        @if(Auth::user()->rol === 'admin')
                            <span class="inline-flex items-center bg-blue-600 text-white text-sm font-medium rounded-md px-3 py-1 shadow-md ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.998 2.25c.37 0 .733.099 1.047.284l6.833 3.977a1.463 1.463 0 01.72 1.026c.091.51.184 1.261.184 2.113 0 5.086-3.263 9.564-8.506 11.682a1.464 1.464 0 01-1.065 0c-5.243-2.118-8.506-6.596-8.506-11.682 0-.852.093-1.603.184-2.113a1.463 1.463 0 01.72-1.026l6.833-3.977a1.464 1.464 0 011.047-.284z" clip-rule="evenodd" />
                    </svg>
                    Admin
                </span>
                        @endif
                    </li>
                    <!-- Botón CREAR TICKET -->
                    <li>
                        <button id="btn-registrar-incidencia" class="btn-registrar hover:shadow-md transition-transform transform hover:scale-105">
                            CREAR TICKET ⚠️
                        </button>
                    </li>
                    <!-- Botón PERFIL -->
                    <li>
                        <a href="{{ route('perfil') }}" class="hover:text-gray-300 text-2xl" title="Perfil de usuario">
                            <i class="fas fa-user-circle"></i>
                        </a>
                    </li>
                    <!-- Botón CERRAR SESIÓN -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-gray-300 text-2xl" title="Cerrar sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </li>
                @else
                    <!-- Usuario no autenticado -->
                    <li class="flex items-center justify-center">
                        <a href="{{ route('login') }}" class="hover:text-gray-300 text-2xl" title="Iniciar sesión">
                            <i class="fas fa-user"></i>
                        </a>
                    </li>
                @endif
                <!-- Botón NOTIFICACIONES -->
                <li>
                    <a href="#" class="hover:text-gray-300 relative text-2xl" title="Notificaciones">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"></span>
                    </a>
                </li>
                <!-- Botón AJUSTES -->
                <li>
                    <a href="#" class="hover:text-gray-300 text-2xl" title="Ajustes">
                        <i class="fas fa-cog"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<!-- Contenedor principal con menú lateral y contenido central -->
<div class="flex">
    <!-- Menú lateral -->
    <nav id="sidebar" class="w-1/8 bg-gray-700 text-white h-screen px-4 py-6 relative"> <!-- Añadimos "relative" al menú -->
        <button id="toggle-sidebar" class="absolute top-4 right-[-20px] bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition duration-200">
            <i class="fas fa-arrow-left"></i>
        </button>
        <ul>
            <li class="mb-2">
                <a href="/incidencias" class="block py-2 px-2 hover:bg-gray-600 rounded text-sm">Incidencias</a>
            </li>
            <li class="mb-2">
                <a href="/usuarios" class="block py-2 px-2 hover:bg-gray-600 rounded text-sm">Usuarios</a>
            </li>
            <li class="mb-2">
                <a href="/estadisticas" class="block py-2 px-2 hover:bg-gray-600 rounded text-sm">Estadísticas</a>
            </li>
        </ul>
    </nav>

    <!-- Contenido central -->
    <main class="flex-1 p-4">
        @yield('content')
    </main>
</div>
<!-- MODAL PARA REGISTRAR LA INCIDENCIA -->
<div id="modal-registrar-incidencia" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl p-8 rounded-lg relative"> <!-- Ancho ajustado -->
        <!-- Botón de cierre (la "X") -->
        <button id="cerrar-modal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Título del modal -->
        <h2 class="text-2xl font-semibold mb-6 text-blue-600">Registrar Nueva Incidencia</h2>

        <!-- Perfil del usuario -->
        <div class="mb-6 flex items-center space-x-4">
            <!-- Foto del usuario -->
            <img src="{{ Auth::user()->foto_url ?? asset('images/default-avatar.png') }}" alt="Foto de perfil" class="w-12 h-12 rounded-full">
            <!-- Nombre del usuario -->
            <span class="text-lg font-medium text-gray-700">
            {{ Auth::check() ? Auth::user()->nombre : 'Usuario no autenticado' }}
        </span>        </div>

        <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Título -->
            <div class="mb-6">
                <label for="titulo" class="block text-gray-700 font-bold">Título</label>
                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    required
                    class="w-full border rounded px-4 py-3"
                    placeholder="Ingrese un título descriptivo"
                    maxlength="100" />
            </div>

            <!-- Descripción -->
            <div class="mb-6">
                <label for="descripcion" class="block text-gray-700 font-bold">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    required
                    class="w-full border rounded px-4 py-3"
                    placeholder="Describa detalladamente la incidencia"
                    maxlength="500"></textarea>
            </div>

            <!-- Categoría -->
            <div class="mb-6">
                <label for="categoria" class="block text-gray-700 font-bold">Categoría</label>
                <select
                    id="categoria"
                    name="categoria"
                    required
                    class="w-full border rounded px-4 py-3">
                    <option value="" disabled selected>Seleccione una categoría</option>
                    <option value="hardware">Hardware</option>
                    <option value="software">Software</option>
                    <option value="seguridad">Seguridad</option>
                    <option value="accesos">Accesos</option>
                    <option value="redes">Redes</option>
                    <option value="correoElectronico">Correo Electrónico</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <!-- Prioridad -->
            <div class="mb-6">
                <label for="prioridad" class="block text-gray-700 font-bold">Prioridad</label>
                <select
                    id="prioridad"
                    name="prioridad"
                    required
                    class="w-full border rounded px-4 py-3">
                    <option value="" disabled selected>Seleccione una prioridad</option>
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>
                </select>
            </div>

            <!-- Archivo adjunto -->
            <div class="mb-6">
                <label for="archivo" class="block text-gray-700 font-bold">Archivo adjunto</label>
                <input
                    type="file"
                    id="archivo"
                    name="archivo"
                    class="w-full border rounded px-4 py-3"
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />
                <small class="text-gray-500">Formatos permitidos: JPG, PNG, PDF, DOC, DOCX</small>
            </div>

            <!-- Botón de enviar -->
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600 transition-all duration-200">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>
<!-- MENSAJE FLASH  -->
@if (session('success'))
    <div id="flash-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('flash-message').remove();
        }, 3000); // El mensaje desaparecerá después de 3 segundos
    </script>
@endif
<!-- -------------------------------------------------- -->
<!-- -------------------------------------------------- -->
<!-- MODAL DE NOTIFICACIÓN -->
@php
    \Log::info('Valor de la sesión ocultar_modal: ' . session('ocultar_modal'));
@endphp
<div id="modalNotificacion" class="fixed inset-0 flex items-center justify-center z-50 hidden"
     data-ocultar-modal="{{ session('ocultar_modal') ? 'true' : 'false' }}">
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Aviso Importante</h2>
        <p class="text-gray-600 mb-6">
            Las incidencias enviadas no pueden ser modificadas posteriormente. Por favor, revisa toda la información antes de enviarla.
        </p>
        <div class="flex justify-end space-x-4">
            <button id="cerrarModalNotificacion" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Entendido
            </button>
            <form id="formNoMostrarMas" data-url="{{ route('noMostrarModal') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    No mostrar más
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
