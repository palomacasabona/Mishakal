@extends('layouts.app')

@section('title', 'Detalles de la Incidencia')

@section('content')
    <!-- Botón flotante para parar las flores -->
    <button id="openPetalModal" class="fixed bottom-5 right-5 bg-pink-500 text-white px-4 py-2 rounded-full shadow-lg hover:bg-pink-600 z-50 animate-bounce">
        🌸 Parar flores
    </button>

    <!-- Modal de confirmación -->
    <div id="petalModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
            <h2 class="text-xl font-bold mb-4">¿Parar las flores?</h2>
            <div class="flex justify-center gap-4">
                <button id="stopPetals" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Sí</button>
                <button id="closePetalModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">No</button>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6 py-10">

        {{-- MENSAJES FLASH (EXITO o ERROR) --}}
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- CABECERA --}}
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Detalles de la Incidencia</h1>

        <div class="bg-white shadow-lg rounded-lg p-6">

            {{-- INFO BÁSICA DE LA INCIDENCIA --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ $incidencia->titulo }}</h2>
                <p class="text-sm text-gray-500">ID: {{ $incidencia->id_incidencia }}</p>
                <p class="text-sm text-gray-500">Fecha de Creación: {{ $incidencia->fecha_creacion }}</p>
            </div>

            {{-- DESCRIPCIÓN --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Descripción</h3>
                <p class="text-gray-600">{{ $incidencia->descripcion }}</p>
            </div>

            {{-- ESTADO Y PRIORIDAD --}}
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

            {{-- ASIGNADO A --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Asignado A</h3>
                @if ($incidencia->asignado_a)
                    <p class="text-gray-600">{{ $incidencia->asignado_a }}</p>
                @else
                    <p class="text-gray-500">No asignado</p>
                @endif

                {{-- BOTÓN AUTOASIGNAR SOLO SI ES ADMIN --}}
                @if (auth()->check() && auth()->user()->rol === 'admin' && !$incidencia->asignado_a)                    <div class="mt-4">
                        <form action="{{ route('incidencias.autoasignar', $incidencia->id_incidencia) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Autoasignar
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- ARCHIVO ADJUNTO --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Archivo Adjunto</h3>
                @if ($incidencia->archivo)
                    @php
                        $rutaPublica = asset('storage/' . $incidencia->archivo);
                    @endphp
                    <img src="{{ $rutaPublica }}" alt="Archivo Adjunto" class="max-w-md w-full h-auto rounded shadow-lg mx-auto">                @else
                    <p class="text-gray-500">No hay archivo adjunto disponible.</p>
                @endif
            </div>

            {{-- BOTÓN VOLVER --}}
            <div class="mt-6 flex justify-end">
                <a href="{{ route('perfil') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Volver al Perfil
                </a>
            </div>

            {{-- HILO DE MENSAJES --}}
            <div class="mt-10">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Mensajes</h3>
                @foreach($incidencia->mensajes as $mensaje)
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        {{-- Si no encuentra al remitente, muestra "Usuario eliminado" --}}
                        <p class="text-sm text-gray-500">
                            De:
                            {{ optional($mensaje->remitente)->nombre ?? 'Usuario eliminado' }}
                            {{ optional($mensaje->remitente)->apellido ?? '' }}
                        </p>
                        <p class="text-gray-700">{{ $mensaje->contenido }}</p>
                        <p class="text-sm text-gray-500 mt-2">{{ $mensaje->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endforeach
            </div>
            {{-- FORMULARIO ENVIAR MENSAJE --}}
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700">Enviar Mensaje</h3>

                <form action="{{ route('mensajes.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="incidencia_id" value="{{ $incidencia->id_incidencia }}">
                    @if(auth()->id() == $incidencia->usuario_id)
                        <input type="hidden" name="destinatario_id" value="{{ $incidencia->asignado_a }}">
                    @else
                        <input type="hidden" name="destinatario_id" value="{{ $incidencia->usuario_id }}">
                    @endif

                    <textarea name="contenido"
                              class="w-full p-4 border rounded-lg mb-2 focus:outline-none focus:ring focus:border-blue-300"
                              rows="4"
                              placeholder="Escribe tu mensaje aquí"
                              required>{{ old('contenido') }}</textarea>

                    @error('contenido')
                    <p class="text-sm text-red-500 mb-2">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
                        Enviar
                    </button>
                </form>
            </div>

            {{-- PAGINADOR --}}
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
    {{-- <div class="petal hidden"></div> --}}
@endsection
