<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mishakal')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon_io/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">

    @vite('resources/css/app.css') <!-- Estilos globales -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-6xl w-full p-6">
    <!-- Branding -->
    <div class="flex flex-col items-center lg:items-start justify-center text-center lg:text-left space-y-4">
        <div class="flex items-center justify-center space-x-4">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo Mishakal" class="h-32">
            <!-- Texto -->
            <h1 class="text-6xl font-bold text-blue-500">MISHAKAL</h1>
        </div>
        <p class="text-3xl text-gray-600 max-w-2xl leading-relaxed">
             Te ayuda a gestionar y organizar tus incidencias de manera eficiente.
        </p>
    </div>

    <!-- Login and Register Forms -->
    <div class="bg-white shadow-md rounded-lg p-10">
        <!-- Login Form -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Iniciar Sesión</h2>
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required class="w-full border rounded-md px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" required class="w-full border rounded-md px-4 py-3 focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-3 text-lg rounded-md hover:bg-blue-600 transition duration-200">Iniciar Sesión</button>
            </form>
        </div>
        <hr class="my-8">
        <!-- Register Form -->
        <button type="submit" class="w-full bg-green-500 text-white py-4 text-2xl font-bold rounded-lg hover:bg-green-600 shadow-lg transition-transform transform hover:scale-105">
            Crear Cuenta
        </button>
    </div>
</div>
</body>
</html>
