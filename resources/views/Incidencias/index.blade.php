@extends('layouts.app') <!-- Se refiere al layout definido en 'resources/views/layouts/app.blade.php' -->

@section('title', 'Listado de Incidencias')  <!--  Título específico de esta página -->

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Listado de Incidencias</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Título</th>
                <th class="border px-4 py-2">Categoría</th>
                <th class="border px-4 py-2">Prioridad</th>
                <th class="border px-4 py-2">Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($incidencias as $incidencia)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $incidencia->id }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->titulo }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->categoria }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->prioridad }}</td>
                    <td class="border px-4 py-2">{{ $incidencia->estado }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
