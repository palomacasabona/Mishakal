@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <!-- depurar -->


        <!-- MENSAJE DE ÉXITO -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Éxito:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- TÍTULO PRINCIPAL -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">Perfil de Usuario</h1>
        <!-- -------------------------------------------------- -->

        <!-- INFORMACIÓN DEL USUARIO -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
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
                <button id="btnEditarPerfil" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-auto">
                    Editar Perfil
                </button>
            </div>
        </div>
        <!-- ---------------------------------------------------->
        <!-- DASHBOARD DE ESTADÍSTICAS -->
        <!-- SEMICIRCULO O SEMITOROIDE INCICA % DE INCIDENCIAS -->

        <div class="flex justify-center items-center space-x-4 mt-4 mb-2">
            <!-- Semicírculo -->
            <div class="w-1/2 flex justify-left">
                <canvas id="semicircleChart" style="width: 400px; height:250px;"></canvas>
            </div>
            <!-- Explicación -->
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-6 flex items-start space-x-2">
                <!-- Ícono de información -->
                <i class="fas fa-info-circle text-blue-500 text-2xl mt-1"></i>
                <!-- Contenido del mensaje -->
                <div>
                    <p class="text-base">
                        Este gráfico muestra el porcentaje y número de incidencias agrupadas por categorías.
                        Para obtener datos actualizados en tiempo real, por favor asegúrese de actualizar la aplicación periódicamente.
                        Al pasar el cursor sobre cada sección del gráfico, se mostrará información detallada.
                    </p>
                </div>
            </div>
        </div>

        @php
            // Pasar datos al JavaScript como JSON
            $labels = json_encode(array_keys($incidenciasPorCategoria->toArray()));
            $dataValues = json_encode(array_column($incidenciasPorCategoria->toArray(), 'count'));
            $colors = json_encode(['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6c757d', '#e83e8c', '#fd7e14']);
        @endphp

        <!-- ---------------------------------------------------->
        <!-- DESGLOSE POR CATEGORÍAS -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Incidencias por Categoría</h2>
            @php
                $colores = [
                    '#007bff', // Azul principal
                    '#28a745', // Verde principal
                    '#ffc107', // Amarillo principal
                    '#17a2b8', // Azul claro
                    '#6c757d', // Gris
                    '#e83e8c', // Rosa vibrante
                    '#fd7e14', // Naranja cálido
                ];
                $colorIndex = 0;
            @endphp
            <ul>
                @foreach ($incidenciasPorCategoria as $categoria => $datos)
                    <li class="mb-4">
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-800 font-medium">{{ ucfirst($categoria) }}</span>
                            <span class="text-gray-600">{{ $datos['count'] }} ({{ $datos['percentage'] }}%)</span>
                        </div>
                        <!-- Barra de progreso -->
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="h-4 rounded-full"
                                 style="width: {{ $datos['percentage'] }}%; background-color: {{ $colores[$colorIndex++] }} !important;">
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Depuración para verificar valores -->
        {{--@foreach ($incidencias as $incidencia)
            @dd($incidencia->archivo);
        @endforeach}}
        <!-- Depuración para verificar incidencias -->
        @dd($incidencias)--}}
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
                {{--@dd($incidencias);--}}
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
                        <!--Miniatura -->
                        <td class="px-4 py-2 text-center">

                            <!-- NO SE MUESTRA!!!!!!!⚠️⚠️ -->
                            @if ($incidencia->archivo))

                            @if (!empty($incidencia->archivo) && file_exists(public_path('storage/' . $incidencia->archivo)))
                                {{-- Archivo existe físicamente --}}
                                @php
                                    $extensionesImagen = ['jpg', 'jpeg', 'png'];
                                    $extension = pathinfo($incidencia->archivo, PATHINFO_EXTENSION);
                                @endphp
                                {{-- Depuración previa al if --}}
                                @if (in_array($extension, $extensionesImagen))
                                    {{-- Mostrar miniatura si es imagen --}}
                                    <img src="{{ asset('storage/' . $incidencia->archivo) }}" alt="Miniatura" class="w-16 h-16 object-cover rounded">
                                @else
                                    {{-- Enlace para descargar si no es imagen --}}
                                    <a href="{{ asset('storage/' . $incidencia->archivo) }}" target="_blank" class="text-blue-500">
                                        Descargar Archivo
                                    </a>
                                @endif
                            @else
                                {{-- Mostrar mensaje cuando no hay archivo --}}
                                <span class="text-gray-500">Sin Archivo</span>
                            @endif
                                <!-- NO SE MUESTRA ⬆️⬆️ -->
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
    </div>
    <!-- -------------------------------------------------- -->
    <!-- -------------------------------------------------- -->
    <!-- MODAL PARA EDITAR EL PERFIL -->
    <div id="modalEditarPerfil" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg modal-content">
            <!-- Header del modal -->
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">Editar Perfil</h2>
                <button id="btnCerrarModal" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>

            <!-- MODAL PARA EDITAR USUARIO -->
            <div class="p-6">

                <form id="formEditarPerfil" method="POST" action="{{ route('usuario.update', ['id' => auth()->user()->id_usuario]) }}" enctype="multipart/form-data">                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="{{ auth()->user()->nombre }}" required
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('nombre')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="mb-4">
                        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="{{ auth()->user()->apellido }}" required
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('apellido')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-4">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" value="{{ auth()->user()->telefono }}" required
                               pattern="[0-9]{9}" title="Debe contener 9 dígitos"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('telefono')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto de perfil -->
                    <div class="mb-4">
                        <label for="foto_perfil" class="block text-sm font-medium text-gray-700">Foto de Perfil:</label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @error('foto_perfil')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end mt-6">
                        <button type="button" id="cancelarEditarPerfil" class="mr-4 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------- -->
    <!-- -------------------------------------------------- -->
    <!-- MODAL DE NOTIFICACIÓN -->
    <div id="modalNotificacion" class="fixed inset-0 flex items-center justify-center z-50 hidden"
         data-ocultar-modal="{{ session('ocultar_modal') ? 'true' : '' }}">
        <div class="relative bg-white rounded-lg shadow-lg w-full max-w-sm p-6 animate-bounce-in">
            <!-- Bocadillo de pensar -->
            <div class="absolute -top-6 -left-6 w-16 h-16 rounded-full bg-white border-2 border-gray-300"></div>
            <div class="absolute -top-10 -right-4 w-8 h-8 rounded-full bg-white border-2 border-gray-300"></div>
            <div class="absolute -top-12 -right-16 w-4 h-4 rounded-full bg-white border-2 border-gray-300"></div>

            <!-- Contenido del modal -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aviso Importante</h2>
            <p class="text-gray-600 mb-6">
                Las incidencias enviadas no pueden ser modificadas posteriormente. Por favor, revisa toda la información antes de enviarla.
            </p>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <!-- Botón para cerrar el modal -->
                <button id="cerrarModalNotificacion" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Entendido
                </button>

                <!-- Botón para no mostrar más -->
                <form action="{{ route('noMostrarModal') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        No mostrar más
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
