@extends('layouts.app') {{-- Extiende la plantilla base llamada "app" --}}

@section('title', 'Detalles de la Incidencia') {{-- Define el título de la página --}}

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10"> {{-- Contenedor principal con márgenes y padding --}}

        {{-- Muestra un mensaje de éxito si existe en la sesión --}}
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Muestra un mensaje de error si existe en la sesión --}}
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Título principal --}}
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Detalles de la Incidencia</h1>

        <div class="bg-white shadow-lg rounded-lg p-6"> {{-- Caja blanca con sombra --}}

            {{-- Título, ID y fecha de la incidencia --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ $incidencia->titulo }}</h2>
                <p class="text-sm text-gray-500">ID: {{ $incidencia->id_incidencia }}</p>
                <p class="text-sm text-gray-500">Fecha de Creación: {{ $incidencia->fecha_creacion }}</p>
            </div>

            {{-- Descripción de la incidencia --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Descripción</h3>
                <p class="text-gray-600">{{ $incidencia->descripcion }}</p>
            </div>

            {{-- Estado y prioridad de la incidencia --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Estado</h3>
                    <span class="px-4 py-2 inline-block rounded
                    {{ $incidencia->estado == 'en proceso' ? 'bg-yellow-200 text-yellow-800' :
                       ($incidencia->estado == 'cerrada' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800') }}">
                    {{ ucfirst($incidencia->estado) }}
                    </span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Prioridad</h3>
                    <span class="px-4 py-2 inline-block rounded
                    {{ $incidencia->prioridad == 'alta' ? 'bg-red-500 text-white animate-pulse' :
                       ($incidencia->prioridad == 'media' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                    {{ ucfirst($incidencia->prioridad) }}
                    </span>
                </div>
            </div>

            {{-- Información del usuario asignado --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Asignado A</h3>
                @if ($incidencia->asignado_a)
                    <p class="text-gray-600">{{ $incidencia->asignado_a }}</p>
                @else
                    <p class="text-gray-500">No asignado</p>
                @endif

                {{-- Botón para autoasignar solo si el usuario es admin y no está asignado aún --}}
                @if (auth()->user()->is_admin && !$incidencia->asignado_a)
                    <div class="mt-4">
                        <form action="{{ route('incidencias.autoasignar', $incidencia->id_incidencia) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Autoasignar
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Mostrar imagen adjunta si existe --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Archivo Adjunto</h3>
                @if ($incidencia->archivo)
                    @php
                        $rutaPublica = asset('storage/' . $incidencia->archivo);
                    @endphp
                    <img src="{{ $rutaPublica }}" alt="Archivo Adjunto" class="w-full h-auto rounded">
                @else
                    <p class="text-gray-500">No hay archivo adjunto disponible.</p>
                @endif
            </div>

            {{-- Botón para volver al perfil --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('perfil') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Volver al Perfil
                </a>
            </div>

            {{-- Hilo de mensajes --}}
            <div class="mt-10">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Mensajes</h3>
                @foreach($incidencia->mensajes as $mensaje)
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        {{-- Evitamos error si el remitente ha sido eliminado --}}
                        <p class="text-sm text-gray-500">
                            De: {{ $mensaje->remitente->nombre ?? 'Usuario eliminado' }} {{ $mensaje->remitente->apellidos ?? '' }}
                        </p>
                        <p class="text-gray-700">{{ $mensaje->contenido }}</p>
                        <p class="text-sm text-gray-500 mt-2">{{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Formulario para enviar un nuevo mensaje --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700">Enviar Mensaje</h3>
                <form action="{{ route('mensajes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="incidencia_id" value="{{ $incidencia->id_incidencia }}">
                    <input type="hidden" name="destinatario_id" value="{{ $incidencia->usuario_id }}">
                    <textarea name="contenido" class="w-full p-4 border rounded-lg mb-4" rows="4" placeholder="Escribe tu mensaje aquí" required></textarea>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enviar</button>
                </form>
            </div>

            {{-- Paginador de incidencias (si aplica) --}}
            <div class="mt-4">
                @if($incidencias->hasPages())
                    <nav class="flex justify-between">
                        {{ $incidencias->links('pagination::tailwind') }}
                    </nav>
                @else
                    <p class="text-center text-gray-500">No hay más resultados para mostrar.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
