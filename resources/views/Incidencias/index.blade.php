@extends('layouts.app')

@section('title', 'Listado de Incidencias')

@section('content')
    <div class="container mx-auto p-4">


        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Id</th>
                <th class="border px-4 py-2">Título</th>
                <th class="border px-4 py-2">Categoría</th>
                <th class="border px-4 py-2">Prioridad</th>
                <th class="border px-4 py-2">Estado</th>
                <th class="border px-4 py-2">Fecha de Creación</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($incidencias as $incidencia)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $incidencia->id_incidencia }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->titulo }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->categoria }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->prioridad }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->estado }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($incidencia->fecha_creacion)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Paginador -->
    <div class="mt-4">
        {{ $incidencias->appends(request()->query())->links() }}
    </div>
@endsection
