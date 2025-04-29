@extends('layouts.app')

@section('title', 'Perfil del Usuario')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Perfil del Usuario</h1>

        <div class="bg-white rounded shadow p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center">
            {{-- Datos del usuario --}}
            <div>
                <p><strong>ID:</strong> {{ $usuario->id_usuario }}</p>
                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>

                @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin')
                    <p><strong>Email:</strong> {{ $usuario->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'No disponible' }}</p>
                    <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
                    <p><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Actualizado:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>

            {{-- Foto de perfil con modal --}}
            @if((auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin') && $usuario->foto_perfil)
                <div class="mt-6 md:mt-0 md:ml-6">
                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}"
                         alt="Foto de perfil"
                         class="h-24 w-24 rounded-full object-cover border border-gray-300 cursor-pointer"
                         onclick="document.getElementById('modalFoto').classList.remove('hidden')">
                </div>
            @endif
        </div>

        {{-- Modal para ampliar imagen --}}
        @if((auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin') && $usuario->foto_perfil)
            <div id="modalFoto" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center hidden z-50">
                <div class="relative">
                    <button onclick="document.getElementById('modalFoto').classList.add('hidden')"
                            class="absolute top-0 right-0 mt-2 mr-2 text-white text-2xl">&times;</button>
                    @if($usuario->foto_perfil)
                        <img src="{{ $usuario->foto_perfil }}" alt="Foto de perfil" style="width: 120px; height: 120px; border-radius: 50%;">
                    @else
                        <p>Sin foto de perfil</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Aviso si no es admin --}}
        @if(!(auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin'))
            <div class="mt-4 bg-blue-100 border border-blue-300 text-blue-700 p-4 rounded">
                ⚠️ Algunos detalles de este usuario están restringidos y solo son visibles para administradores.
            </div>
        @endif

        {{-- Incidencias --}}
        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'superadmin')
            <h2 class="text-xl font-semibold mb-4 mt-8">Incidencias del Usuario</h2>
            <ul class="list-disc list-inside">
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
