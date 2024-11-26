
@vite('resources/css/app.css')

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-3xl grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Login -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold mb-4">Iniciar Sesión</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required class="w-full border rounded-md px-4 py-2">
                        <span class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required class="w-full border rounded-md px-4 py-2">
                        <span class="absolute inset-y-0 right-3 flex items-center">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Entrar</button>
            </form>
        </div>

        <!-- Register -->
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold mb-4">Registrarse</h2>
            <form action="{{ route('register') }}" method="POST">
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
</div>
