@extends('layouts.app')
{{-- Extiende la plantilla base llamada "app.blade.php", así reutilizas la estructura general de la web (head, scripts, etc.) --}}

@section('content')
    {{-- Define la sección de contenido que se insertará en la plantilla base --}}

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        {{-- Contenedor que centra el contenido vertical y horizontalmente y da fondo gris claro --}}

        <div class="bg-white p-6 rounded shadow-md text-center max-w-md">
            {{-- Caja blanca con padding, bordes redondeados, sombra, texto centrado y un ancho máximo --}}

            <h1 class="text-2xl font-bold text-red-600 mb-4">¡Sesión expirada!</h1>
            {{-- Título grande en rojo para avisar del error --}}

            <p class="text-gray-700 mb-6">
                Por seguridad, tu sesión ha caducado. Por favor, inicia sesión nuevamente para continuar.
            </p>
            {{-- Mensaje explicativo para el usuario --}}

            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Iniciar sesión
            </a>
            {{-- Botón que redirige a la ruta de login con estilos tailwind (azul, blanco, redondeado, efecto hover) --}}

        </div>
    </div>

@endsection
{{-- Fin de la sección de contenido --}}
