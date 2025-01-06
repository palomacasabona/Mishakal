@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Listado de Usuarios</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Correo Electrónico</th>
                <th class="border px-4 py-2">Perfil</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="border px-4 py-2">{{ $usuario->id_usuario }}</td>
                    <td class="border px-4 py-2">{{ $usuario->nombre }}</td>
                    <td class="border px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="text-blue-500 hover:underline">
                            Ver Perfil
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
