@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- Título -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Panel de Usuario</h1>

        <!-- Dashboard de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Incidencias Totales</h2>
                <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalIncidencias }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Abiertas</h2>
                <p class="text-4xl font-bold text-green-600 mt-2">{{ $incidenciasAbiertas }}</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Cerradas</h2>
                <p class="text-4xl font-bold text-red-600 mt-2">{{ $incidenciasCerradas }}</p>
            </div>
        </div>

        <!-- Listado de incidencias -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Tus Incidencias</h2>
            <table class="min-w-full table-auto">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600">ID</th>
                    <th class="px-4 py-2 text-left text-gray-600">Título</th>
                    <th class="px-4 py-2 text-left text-gray-600">Estado</th>
                    <th class="px-4 py-2 text-left text-gray-600">Fecha</th>
                    <th class="px-4 py-2 text-center text-gray-600">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($incidencias as $incidencia)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $incidencia->id }}</td>
                        <td class="px-4 py-2">{{ $incidencia->titulo }}</td>
                        <td class="px-4 py-2">{{ ucfirst($incidencia->estado) }}</td>
                        <td class="px-4 py-2">{{ $incidencia->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('incidencias.show', $incidencia->id) }}" class="text-blue-500 hover:underline">Ver</a>
                            <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="text-yellow-500 hover:underline ml-4">Editar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
