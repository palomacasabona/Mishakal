@extends('layouts.app')

@section('title', 'Listado de Incidencias')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Listado de Incidencias</h1>

        <table class="table-auto w-full border-collapse shadow-lg rounded">
            <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Título</th>
                <th class="border px-4 py-2">Categoría</th>
                <th class="border px-4 py-2">Prioridad</th>
                <th class="border px-4 py-2">Estado</th>
                <th class="border px-4 py-2">Fecha</th>
                <th class="border px-4 py-2">Registrado por</th>
                <th class="border px-4 py-2">Asignada a</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($incidencias as $incidencia)
                <tr class="bg-white border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-2 text-blue-600 font-semibold">
                        <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}" class="hover:underline">
                            {{ $incidencia->id_incidencia }}
                        </a>
                    </td>

                    <td class="px-4 py-2 text-gray-800 font-medium">{{ $incidencia->titulo }}</td>
                    <td class="px-4 py-2 text-gray-600">{{ $incidencia->categoria }}</td>

                    {{-- Prioridad con color --}}
                    <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($incidencia->prioridad == 'Alta') bg-red-600
                                @elseif($incidencia->prioridad == 'Media') bg-orange-500
                                @else bg-green-500 @endif">
                                {{ $incidencia->prioridad }}
                            </span>
                    </td>

                    {{-- Estado con badge --}}
                    <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($incidencia->estado == 'Resuelta') bg-green-100 text-green-800
                                @elseif($incidencia->estado == 'En proceso') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $incidencia->estado }}
                            </span>
                    </td>

                    <td class="px-4 py-2 text-gray-500 text-sm">
                        {{ \Carbon\Carbon::parse($incidencia->fecha_creacion)->format('d/m/Y H:i') }}
                    </td>

                    {{-- Registrado por --}}
                    <td class="px-4 py-2 text-sm text-gray-600">
                        {{ $incidencia->creador->nombre ?? 'Desconocido' }}
                    </td>

                    {{-- Asignada a --}}
                    <td class="px-4 py-2 text-sm">
                        @if($incidencia->asignado)
                            <div class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                👤 {{ $incidencia->asignado->nombre }}
                            </div>
                            @if($incidencia->estado == 'En proceso')
                                <span class="ml-1 text-yellow-600 text-xs">(⚙ en curso)</span>
                            @endif
                        @else
                            <span class="text-gray-400 italic text-xs">No asignado</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $incidencias->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
