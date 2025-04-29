@extends('layouts.app')
{{-- Se extiende del layout principal llamado 'app' --}}

@section('title', 'Perfil del Usuario')
{{-- Se define el título de la página --}}

@section('content')
    {{-- Comienza la sección de contenido de la página --}}

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Perfil del Usuario</h1>

        <div class="bg-white rounded shadow p-6 mb-6">
            {{-- Información básica del usuario (visible para todos) --}}
            <p><strong>ID:</strong> {{ $usuario->id_usuario }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>

            {{-- Se muestra información sensible solo si el usuario autenticado es admin o superadmin --}}
            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin')
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No disponible' }}</p>
                <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
                <p><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>

                {{-- Si el usuario tiene una foto de perfil, se muestra --}}
                @if ($usuario->foto_perfil)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de perfil" class="h-24 w-24 rounded-full object-cover">
                    </div>
                @endif
            @else
                {{-- Mensaje para usuarios que no tienen permiso para ver los datos sensibles --}}
                <div class="mt-4 bg-blue-100 border border-blue-300 text-blue-700 p-4 rounded">
                    ⚠️ Algunos detalles de este usuario están restringidos y solo son visibles para administradores.
                </div>
            @endif
        </div>

        {{-- Sección de incidencias, también solo visible para admin o superadmin --}}
        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin')
            <h2 class="text-xl font-semibold mb-4">Incidencias del Usuario</h2>
            <ul class="list-disc list-inside">
                {{-- Se listan las incidencias si existen --}}
                @forelse($incidencias as $incidencia)
                    <li>
                        <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}" class="text-blue-500 hover:underline">
                            {{ $incidencia->titulo ?? 'Sin título' }}
                        </a> ({{ $incidencia->estado }})
                    </li>
                @empty
                    <li>No hay incidencias asociadas.</li>
                @endforelse
            </ul>
        @endif
    </div>
@endsection
