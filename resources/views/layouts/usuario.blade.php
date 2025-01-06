@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Perfil de Usuario</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <p><strong>ID:</strong> {{ $usuario->id_usuario }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
        </div>
        <a href="{{ route('usuarios.index') }}" class="text-blue-500 hover:underline mt-4 block">Volver al listado</a>
    </div>
@endsection
