<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplicación de Incidencias')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
<!-- Barra de navegación superior -->
<header class="flex items-center justify-between p-4 bg-blue-700 text-white shadow-md">
    <div class="flex items-center">
        <div class="mr-4">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 sm:h-12 md:h-12 w-auto">
        </div>
        <h1 class="text-lg sm:text-xl font-bold">MISHAKAL</h1>
    </div>
    <!-- Menú para dispositivos grandes -->
    <nav class="hidden md:block">
        <ul class="flex space-x-4">
            <li><a href="#" class="hover:text-gray-300">Log</a></li>
            <li><a href="#" class="hover:text-gray-300">Registrarse</a></li>
            <li><a href="#" class="hover:text-gray-300">Notificaciones</a></li>
            <li><a href="#" class="hover:text-gray-300">Ajustes</a></li>

        </ul>
    </nav>
    <!-- Botón hamburguesa para dispositivos pequeños -->
    <div class="block md:hidden">
        <button id="menu-toggle" class="focus:outline-none">
            <!-- Icono de menú -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</header>

<!-- Contenedor principal con menú lateral y contenido central -->
<div class="flex">
    <!-- Menú lateral -->
    <nav class="w-1/4 bg-gray-700 text-white h-screen p-4">
        <ul>
            <li class="mb-2">
                <a href="/incidencias" class="block py-2 px-4 hover:bg-gray-600 rounded">Incidencias</a>
            </li>
            <li class="mb-2">
                <a href="/usuarios" class="block py-2 px-4 hover:bg-gray-600 rounded">Usuarios</a>
            </li>
            <li class="mb-2">
                <a href="/estadisticas" class="block py-2 px-4 hover:bg-gray-600 rounded">Estadísticas</a>
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
