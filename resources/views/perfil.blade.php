@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- Título -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Perfil de Usuario</h1>

        <!-- Información del usuario -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <div class="flex items-center space-x-4">
                <!-- Foto de perfil -->
                <img src="{{ Auth::user()->foto_url ?? asset('images/default-avatar.png') }}" alt="Foto de perfil"
                     class="w-16 h-16 rounded-full">
                <!-- Nombre y email -->
                <div>
                    <p class="text-lg font-bold text-gray-800">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <!-- BOTON EDITAR PERFIL -->
                <button id="btnEditarPerfil" class="bg-blue-500 text-white px-4 py-2 rounded">Editar Perfil</button>
            </div>
        </div>

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
                        <td class="px-4 py-2">
                            {{ $incidencia->created_at ? $incidencia->created_at->format('d/m/Y') : 'Fecha no disponible' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL PARA MODIFICAR PERFIL -->
    <div id="modalEditarPerfil" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-lg p-8 rounded-lg relative modal-shine">
            <!-- Botón de cerrar -->
            <button id="btnCerrarModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Título del modal -->
            <h2 class="text-2xl font-semibold mb-6 text-blue-600">Editar Perfil</h2>

            <!-- Formulario para editar perfil -->
            <form action="{{ route('usuario.update', Auth::user()->id_usuario) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="nombre" class="block text-gray-700 font-bold">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="{{ Auth::user()->nombre }}" required class="w-full border rounded px-4 py-3">
                </div>
                <div class="mb-6">
                    <label for="apellido" class="block text-gray-700 font-bold">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="{{ Auth::user()->apellido }}" class="w-full border rounded px-4 py-3">
                </div>
                <div class="mb-6">
                    <label for="apellido" class="block text-gray-700 font-bold">Teléfono</label>
                    <input type="text" id="apellido" name="apellido" value="{{ Auth::user()->telefono }}" class="w-full border rounded px-4 py-3">
                </div>
                <div class="mb-6">
                    <label for="foto" class="block text-gray-700 font-bold">Foto de Perfil</label>
                    <input type="file" id="foto" name="foto" class="w-full border rounded px-4 py-3">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-600">Guardar Cambios</button>
            </form>
        </div>
    </div>
    </div>
@endsection
