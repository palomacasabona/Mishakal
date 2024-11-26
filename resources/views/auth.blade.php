<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    @vite('resources/css/app.css') <!-- Estilos globales -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl w-full bg-white p-6 shadow-md rounded-lg">

    <!-- Login -->
    <div class="flex flex-col items-center">
        <h2 class="text-2xl font-bold mb-4">Iniciar Sesión</h2>
        <form action="{{ route('login') }}" method="POST" class="w-full max-w-sm">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" required class="w-full border rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" required class="w-full border rounded-md px-4 py-2">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Entrar</button>
        </form>
    </div>

    <!-- Registro -->
    <div class="flex flex-col items-center">
        <h2 class="text-2xl font-bold mb-4">Registrarse</h2>
        <form action="{{ route('register') }}" method="POST" class="w-full max-w-sm">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                <input type="text" id="name" name="name" required class="w-full border rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" required class="w-full border rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" required class="w-full border rounded-md px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border rounded-md px-4 py-2">
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Crear Cuenta</button>
        </form>
    </div>
</div>
</body>
</html>
