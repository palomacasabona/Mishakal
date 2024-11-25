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
<header class="bg-blue-500 text-white p-4">
    <div class="flex items-center">
        <div class="mr-4">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
        </div>
        <h1 class="text-xl font-bold">MISHAKAL</h1>
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
