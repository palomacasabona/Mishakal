<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Registro</title>
</head>
<body>
<h1>Formulario de Registro</h1>
<form action="{{ route('register') }}" method="POST">
    @csrf
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="password_confirmation">Confirmar Contraseña:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>
    <br>
    <button type="submit">Registrarse</button>
</form>
</body>
</html>
