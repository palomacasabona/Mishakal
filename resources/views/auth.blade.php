<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mishakal - Iniciar Sesión o Registrarse</title>
    @vite('resources/css/app.css') <!-- Estilos globales -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl w-full">
    <!-- Branding -->
    <div class="flex flex-col items-start justify-center text-left p-6 space-y-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Mishakal" class="h-52 mb-6"> <!-- Logo más grande -->
        <h1 class="text-6xl font-bold text-blue-500">MISHAKAL</h1> <!-- Texto más grande -->
        <p class="text-xl text-gray-700 max-w-lg"> <!-- Alineado a la izquierda -->
            Mishakal te ayuda a gestionar y organizar tus incidencias de manera eficiente.
        </p>
    </div>

    <!-- Login and Register Form -->
    <div class="bg-white shadow-md rounded-lg p-10">
        <div class="mb-6">
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
        <div>
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">¿No tienes cuenta?</h2>
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <button type="submit" class="w-full bg-green-500 text-white py-3 text-lg rounded-md hover:bg-green-600 transition duration-200">Crear Cuenta</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
