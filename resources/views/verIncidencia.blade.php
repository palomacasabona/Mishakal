@extends('layouts.app')

@section('title', 'Detalles de la Incidencia')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- DEBUGGER PARA VERIFICAR LAS RUTAS GENERADAS -->
            <!-- TÍTULO PRINCIPAL -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Detalles de la Incidencia</h1>
        <!-- CONTENEDOR PRINCIPAL -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- ENCABEZADO -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ $incidencia->titulo }}</h2>
                <p class="text-sm text-gray-500">ID: {{ $incidencia->id_incidencia }}</p>
                <p class="text-sm text-gray-500">Fecha de Creación: {{ $incidencia->fecha_creacion }}</p>
            </div>
            <!-- DESCRIPCIÓN -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Descripción</h3>
                <p class="text-gray-600">{{ $incidencia->descripcion }}</p>
            </div>
            <!-- ESTADO Y PRIORIDAD -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Estado</h3>
                    <span class="px-4 py-2 inline-block rounded {{ $incidencia->estado == 'en proceso' ? 'bg-yellow-200 text-yellow-800' : ($incidencia->estado == 'cerrada' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800') }}">
                        {{ ucfirst($incidencia->estado) }}
                    </span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Prioridad</h3>
                    <span class="px-4 py-2 inline-block rounded {{ $incidencia->prioridad == 'alta' ? 'bg-red-500 text-white animate-pulse' : ($incidencia->prioridad == 'media' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                        {{ ucfirst($incidencia->prioridad) }}
                    </span>
                </div>
            </div>
            <!-- ARCHIVO ADJUNTO -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Archivo Adjunto</h3>
                @if ($incidencia->archivo)
                    @php
                        $archivo = $incidencia->archivo;
                        $rutaPublica = asset('storage/' . $archivo->ruta_archivo);
                    @endphp

                    <img src="{{ $rutaPublica }}" alt="Archivo Adjunto" class="w-full h-auto rounded">
                @else
                    <p class="text-gray-500">No hay archivo adjunto disponible.</p>
                @endif
            </div>

            <!-- BOTÓN DE VOLVER -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('perfil') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Volver al Perfil
                </a>
            </div>
        </div>
    </div>
@endsection
