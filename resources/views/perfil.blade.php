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
                <!-- INFORMACIÓN COMPLETA DEL USUARIO -->
                <div>
                    <p class="text-lg font-bold text-gray-800">ID: {{ Auth::user()->id_usuario }}</p>
                    <p class="text-lg font-bold text-gray-800">Nombre: {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                    <p class="text-sm text-gray-600">Email: {{ Auth::user()->email }}</p>
                    <p class="text-sm text-gray-600">Teléfono: {{ Auth::user()->telefono }}</p>
                </div>
                <!-- BOTÓN EDITAR PERFIL -->
                <button id="btnEditarPerfil" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Editar Perfil
                </button>
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
                <h2 class="text-xl font-semibold text-gray-700">Porcentaje Abiertas</h2>
                <p class="text-4xl font-bold
    @if ($totalIncidencias > 0 && $incidenciasAbiertas / $totalIncidencias === 1) text-green-600
    @else text-yellow-600 @endif mt-2">
                    {{ $totalIncidencias > 0 ? round(($incidenciasAbiertas / $totalIncidencias) * 100, 2) : 0 }}%
                </p>
            </div>
        </div>

        <!-- LISTADO DE INCIDENCIAS -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Tus Incidencias</h2>
            <table class="min-w-full table-auto">
                <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-gray-600">ID</th>
                    <th class="px-4 py-2 text-left text-gray-600">Título</th>
                    <th class="px-4 py-2 text-left text-gray-600">Descripción</th>
                    <th class="px-4 py-2 text-center text-gray-600">Miniatura</th>
                    <th class="px-4 py-2 text-left text-gray-600">Estado</th>
                    <th class="px-4 py-2 text-center text-gray-600">Prioridad</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($incidencias as $incidencia)
                    <tr class="border-t">
                        <!-- ID con enlace -->
                        <td class="px-4 py-2">
                            <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}"
                               class="text-blue-500 hover:underline">
                                {{ $incidencia->id_incidencia }}
                            </a>
                        </td>
                        <!-- Título -->
                        <td class="px-4 py-2">{{ $incidencia->titulo }}</td>
                        <!-- Descripción -->
                        <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($incidencia->descripcion, 50) }}</td>
                        <!-- Miniatura -->
                        <td class="px-4 py-2 text-center">
                            @if ($incidencia->archivo)
                                @php
                                    $extensionesImagen = ['jpg', 'jpeg', 'png'];
                                    $extension = pathinfo($incidencia->archivo, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array($extension, $extensionesImagen))
                                    <img src="{{ asset('storage/' . $incidencia->archivo) }}" alt="Miniatura" class="w-16 h-16 object-cover rounded">
                                @else
                                    <a href="{{ asset('storage/' . $incidencia->archivo) }}" target="_blank" class="text-blue-500 hover:underline">
                                        Descargar Archivo
                                    </a>
                                @endif
                            @else
                                <span class="text-gray-500">Sin Archivo</span>
                            @endif
                        </td>
                        <!-- Estado -->
                        <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded {{ $incidencia->estado == 'en proceso' ? 'bg-yellow-200 text-yellow-800' : ($incidencia->estado == 'cerrada' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800') }}">
                        {{ ucfirst($incidencia->estado) }}
                    </span>
                        </td>
                        <!-- Prioridad -->
                        <td class="px-4 py-2 text-center">
                    <span class="px-2 py-1 rounded {{ $incidencia->prioridad == 'alta' ? 'bg-red-500 text-white animate-pulse' : ($incidencia->prioridad == 'media' ? 'bg-yellow-500 text-white' : 'bg-green-500 text-white') }}">
                        {{ ucfirst($incidencia->prioridad) }}
                    </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- MODAL EDITAR PERFIL -->
        <div id="modalEditarPerfil" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-96 modal-content relative">
                <!-- Botón de cerrar -->
                <button id="btnCerrarModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-4">Editar Perfil</h2>
                <form action="{{ route('usuario.update', ['id' => Auth::user()->id_usuario]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Campo Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ Auth::user()->nombre }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Campo Apellido -->
                    <div class="mb-4">
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" name="apellido" id="apellido" value="{{ Auth::user()->apellido }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Campo Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Campo Teléfono -->
                    <div class="mb-4">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ Auth::user()->telefono }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Campo Foto -->
                    <div class="mb-4">
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto de Perfil</label>
                        <input type="file" name="foto" id="foto" class="mt-1 block w-full">
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Cambios</button>
                        <button id="btnCerrarModal" type="button" class="ml-2 bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
