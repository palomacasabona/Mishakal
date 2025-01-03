<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión o Registrate</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
<div class="flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        <h1 class="text-xl font-bold mb-4">Inicia Sesión</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="w-full p-2 border rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded mt-1" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Entrar</button>
        </form>
    </div>
</div>
</body>
</html>
