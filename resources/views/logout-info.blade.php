@extends('layouts.app')

@section('content')
    <div class="text-center mt-10">
        <h1 class="text-2xl font-bold text-red-600">⚠ Acción inválida</h1>
        <p class="mt-4">La sesión solo puede cerrarse desde el botón seguro de "Cerrar sesión".</p>
        <p class="mt-2">Por seguridad, esta ruta no está disponible directamente.</p>
        <a href="{{ url('/dashboard') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Volver al panel
        </a>
    </div>
@endsection
