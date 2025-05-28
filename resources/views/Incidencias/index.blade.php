@extends('layouts.app')

@section('title', 'Listado de Incidencias')

@section('content')
    @if(session('info') || true)
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-800 p-4 mb-6 rounded shadow-md">
            <div class="flex items-start gap-2">
                <span class="text-xl">ℹ️</span>
                <div>
                    <p class="font-semibold">Demoras en el servicio</p>
                    <p class="text-sm">Estamos experimentando una alta demanda. Algunas incidencias podrían tardar más en ser gestionadas. Gracias por tu comprensión.</p>
                </div>
            </div>
        </div>
    @endif
    <div class="container mx-auto p-4">
        <div class="relative">
            <div class="absolute right-0 top-0 mt-[-2rem] bg-white border border-blue-300 text-blue-800 px-4 py-2 rounded-xl shadow-md text-sm flex items-center gap-2 animate-fadeIn">
                <span class="text-lg">💬</span>
                <div>
                    Bienvenido/a, <strong>{{ Auth::user()->nombre ?? 'usuario' }}</strong><br>
                    ¿Listo para revisar tus incidencias?
                </div>
            </div>
        </div>
        <h1 class="text-2xl font-bold text-gray-700 mb-2">Listado de Incidencias</h1>
        <p class="text-sm text-gray-500 mb-6">
            Actualizado a fecha y hora del sistema: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </p>

        <table class="table-auto w-full border-collapse shadow-md rounded">
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
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-4 py-2 text-blue-600 font-semibold">
                        <a href="{{ route('incidencias.show', $incidencia->id_incidencia) }}" class="hover:underline">
                            {{ $incidencia->id_incidencia }}
                        </a>
                    </td>

                    <td class="px-4 py-2 text-gray-800">
                        <div class="font-medium">{{ $incidencia->titulo }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $incidencia->descripcion }}</div>
                    </td>
                    <td class="px-4 py-2 text-gray-600">{{ $incidencia->categoria }}</td>

                    {{-- Prioridad --}}
                    <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-white text-xs
                                @if($incidencia->prioridad == 'alta') bg-red-600 parpadea
                                @elseif($incidencia->prioridad == 'media') bg-orange-500
                                @else bg-green-500 @endif">
                                {{ ucfirst($incidencia->prioridad) }}
                            </span>
                    </td>

                    {{-- Estado --}}
                    <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($incidencia->estado == 'cerrada') bg-red-100 text-red-700 parpadea
                                @elseif($incidencia->estado == 'en proceso') bg-yellow-100 text-yellow-700 parpadea
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($incidencia->estado) }}
                            </span>
                    </td>

                    <td class="px-4 py-2 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($incidencia->fecha_creacion)->format('d/m/Y H:i') }}
                    </td>

                    {{-- Registrado por --}}
                    <td class="px-4 py-2 text-sm">
                        {{ optional($incidencia->registradoPor)->nombre ?? '—' }}
                    </td>

                    {{-- Asignado a --}}
                    <td class="px-4 py-2 text-sm">
                        @if($incidencia->asignado)
                            <div class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                {{ $incidencia->asignado->nombre }}
                                @if($incidencia->estado == 'en proceso')
                                    <span class="ml-1">⚙</span>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">No asignada</span>
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
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('opacity-0'), 4000);
            setTimeout(() => toast.remove(), 5000);
        });
    </script>
@endsection
