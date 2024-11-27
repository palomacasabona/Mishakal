<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Ajustes para el video */
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<!-- Video de fondo -->
<video autoplay muted loop class="background-video">
    <source src="{{ asset('images/background.mp4') }}" type="video/mp4">
</video>

<!-- Contenedor del formulario -->
<div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md animate__animated animate__fadeInDown">
    <!-- Logo -->
    <div class="flex items-center mb-4">
        <!-- Logo alineado a la izquierda -->
        <a href="{{ route('incidencias.index') }}" class="mr-4">
            <img src="{{ asset('images/logo.png') }}" class="h-28 w-auto" alt="Logo">
        </a>
        <!-- Título alineado a la derecha del logo -->
        <h1 class="text-lg sm:text-xl font-bold text-blue-500">MISHAKAL</h1>
    </div>
    <!-- Título -->
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" id="name" name="name" required
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
            <input type="password" id="password" name="password" required
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 shadow-md transition-transform transform hover:scale-105">
            Registrarse
        </button>
    </form>
</div>
</body>
</html>
