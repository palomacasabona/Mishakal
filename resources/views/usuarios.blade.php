@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Listado de Usuarios</h1>

        {{-- Buscador --}}
        <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       placeholder="Buscar por nombre o email..."
                       class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Buscar
                </button>
            </div>
        </form>

        {{-- Tabla de usuarios --}}
        <table class="table-auto w-full border-collapse border border-gray-300 shadow-sm">
            <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Correo Electrónico</th>
                <th class="border px-4 py-2">Perfil</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($usuarios as $usuario)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $usuario->id_usuario }}</td>
                    <td class="border px-4 py-2">{{ $usuario->nombre }}</td>
                    <td class="border px-4 py-2">{{ $usuario->email }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('usuarios.show', $usuario->id_usuario) }}" class="text-blue-500 hover:underline">
                            Ver Perfil
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">No se encontraron usuarios.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $usuarios->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
