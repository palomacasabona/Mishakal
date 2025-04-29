@extends('layouts.app')
{{-- Extiende la plantilla base layouts.app, para mantener el diseño general de la web --}}

@section('title', 'Sesión expirada')
{{-- Establece el título de la página como "Sesión expirada" --}}

@section('content')
    {{-- Inicia la sección de contenido principal que se insertará en la plantilla base --}}

    <div class="min-h-screen flex flex-col items-center justify-center">
        {{-- Crea un contenedor que ocupa toda la altura de la pantalla y centra su contenido tanto vertical como horizontalmente --}}

        <h1 class="text-4xl font-bold mb-4">419 - Sesión Expirada</h1>
        {{-- Muestra un título grande indicando que la sesión ha expirado --}}

        <p class="mb-8 text-gray-600">Tu sesión ha expirado. Por favor, vuelve a iniciar sesión o refresca la página.</p>
        {{-- Muestra un mensaje explicativo en tono gris claro --}}

        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ir al Login
        </a>
        {{-- Botón que redirige al usuario a la ruta de login, con estilos de fondo azul y hover más oscuro --}}
    </div>

@endsection
{{-- Cierra la sección de contenido --}}
