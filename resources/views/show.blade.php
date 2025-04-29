@extends('layouts.app')

@section('title', 'Perfil del Usuario')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold text-blue-600 mb-6">Perfil del Usuario</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p><strong>ID:</strong> {{ $usuario->id_usuario }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }} {{ $usuario->apellido }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No proporcionado' }}</p>
        </div>

        <a href="{{ route('usuarios.index') }}"
           class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            ← Volver al listado
        </a>
    </div>
@endsection
