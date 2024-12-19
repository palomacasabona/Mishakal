<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicación de Incidencias')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon_io/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/sidebar.js'])
    <!-- Estilos globales -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4fX8FLDl2ozbFp3bVlBUq62irDZnLgMi9GkB9BmU3lVRj7zx3g4k9Ob9pA2bG3D3km0zg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100">
<!-- BARRA DE NAVEGACION SUPERIOR -->
<header class="flex items-center justify-between p-4 text-white shadow-md w-screen" style="background-color: #007bff;">
    <div class="flex items-center">
        <div class="mr-4">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 sm:h-12 md:h-12 w-auto">
        </div>
        <h1 class="text-lg sm:text-xl font-bold">MISHAKAL</h1>
    </div>
    <div class="flex items-center space-x-4">
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
                    <!-- Botón PERFIL -->
                    <li>
                        <a href="{{ route('perfil') }}" class="hover:text-gray-300 text-2xl" title="Perfil de usuario">
                            <i class="fas fa-user-circle"></i>
                        </a>
                    </li>
                    <!-- Botón CERRAR SESIÓN -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:text-gray-300 text-2xl" title="Cerrar sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </li>
                @else
                    <!-- Botón INICIO DE SESIÓN -->
                    <li class="flex items-center justify-center">
                        <a href="{{ route('auth') }}" class="hover:text-gray-300 text-2xl" title="Iniciar sesión">
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
</body>
</html>
