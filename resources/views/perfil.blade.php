@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- MENSAJE DE ÉXITO -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Éxito:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- TÍTULO PRINCIPAL -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Perfil de Usuario</h1>

        <!-- INFORMACIÓN DEL USUARIO -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <div class="flex items-center space-x-4">
                <!-- FOTO DE PERFIL O INICIAL -->
                @if (Auth::user()->foto_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de perfil"
                         class="w-16 h-16 rounded-full">
                @else
                    <div class="w-16 h-16 rounded-full flex items-center justify-center bg-blue-500 text-white font-bold text-lg">
                        {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <!-- NOMBRE Y EMAIL DEL USUARIO -->
                <div>
                    <p class="text-lg font-bold text-gray-800">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- DASHBOARD DE ESTADÍSTICAS -->
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

        <!-- LISTA DE INCIDENCIAS -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Mis Incidencias</h2>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Título</th>
                    <th class="border px-4 py-2">Descripción</th>
                    <th class="border px-4 py-2">Miniatura</th>
                    <th class="border px-4 py-2">Estado</th>
                    <th class="border px-4 py-2">Prioridad</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($incidencias as $incidencia)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $incidencia->id_incidencia }}</td>
                        <td class="border px-4 py-2">{{ $incidencia->titulo }}</td>
                        <td class="border px-4 py-2">{{ $incidencia->descripcion }}</td>
                        <td class="border px-4 py-2">
                            @if ($incidencia->archivo)
                                <img src="{{ asset('storage/' . $incidencia->archivo->ruta_archivo) }}" alt="Archivo" class="w-12 h-12 object-cover">
                            @else
                                No hay archivo
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded
                                    @if ($incidencia->estado === 'en proceso') bg-yellow-200 text-yellow-800
                                    @elseif ($incidencia->estado === 'cerrada') bg-green-200 text-green-800
                                    @else bg-gray-200 text-gray-800 @endif">
                                    {{ ucfirst($incidencia->estado) }}
                                </span>
                        </td>
                        <td class="border px-4 py-2 text-center">
                                <span class="px-2 py-1 rounded
                                    @if ($incidencia->prioridad === 'alta') bg-red-500 text-white animate-pulse
                                    @elseif ($incidencia->prioridad === 'media') bg-yellow-500 text-white
                                    @else bg-green-500 text-white @endif">
                                    {{ ucfirst($incidencia->prioridad) }}
                                </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">No se encontraron incidencias.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
