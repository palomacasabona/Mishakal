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
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">

    <!-- Estilos globales -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4fX8FLDl2ozbFp3bVlBUq62irDZnLgMi9GkB9BmU3lVRj7zx3g4k9Ob9pA2bG3D3km0zg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body class="bg-gray-100">
<!-- Barra de navegación superior -->
<header class="flex items-center justify-between p-4 text-white shadow-md w-screen" style="background-color: #007bff;">
    <div class="flex items-center">
        <div class="mr-4">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 sm:h-12 md:h-12 w-auto">
        </div>
        <h1 class="text-lg sm:text-xl font-bold">MISHAKAL</h1>
    </div>
    <!-- Menú para dispositivos grandes -->
    <nav class="hidden md:block">
        <ul class="flex">
            <li class="pr-8">
                <a href="{{ route('auth') }}" class="hover:text-gray-300 text-2xl">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            </li>
            <li class="px-8">
                <a href="#" class="hover:text-gray-300 text-2xl">
                    <i class="fas fa-user-plus"></i>
                </a>
            </li>
            <li class="px-8">
                <a href="#" class="hover:text-gray-300 relative text-2xl">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"></span>
                </a>
            </li>
            <li class="pl-8">
                <a href="#" class="hover:text-gray-300 text-2xl">
                    <i class="fas fa-cog"></i>
                </a>
            </li>
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
