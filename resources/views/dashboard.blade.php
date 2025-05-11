@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Estadísticas Generales</h1>

        {{-- Indicadores principales --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-100 p-4 rounded shadow text-center">
                <p class="text-xl font-semibold text-blue-700">📝 Total</p>
                <p class="text-3xl font-bold counter" data-target="{{ $totalIncidencias }}">0</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded shadow text-center">
                <p class="text-xl font-semibold text-yellow-700">🔄 En proceso</p>
                <p class="text-3xl font-bold counter" data-target="{{ $enProceso }}">0</p>
            </div>
            <div class="bg-green-100 p-4 rounded shadow text-center">
                <p class="text-xl font-semibold text-green-700">✅ Cerradas</p>
                <p class="text-3xl font-bold counter" data-target="{{ $cerradas }}">0</p>
            </div>
        </div>

        {{-- Indicadores adicionales --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-500">Usuarios</p>
                <p class="text-xl font-bold counter" data-target="{{ $totalUsuarios }}">0</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-500">Incidencias</p>
                <p class="text-xl font-bold counter" data-target="{{ $totalIncidencias }}">0</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-500">Abiertas</p>
                <p class="text-xl font-bold counter" data-target="{{ $porEstado['Abiertas'] ?? 0 }}">0</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-500">Cerradas</p>
                <p class="text-xl font-bold counter" data-target="{{ $porEstado['Cerradas'] ?? 0 }}">0</p>
            </div>
        </div>

        {{-- Gráficos --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-4">Incidencias por Estado</h2>
                <canvas id="estadoChart"></canvas>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-4">Incidencias por Categoría</h2>
                <canvas id="categoriaChart"></canvas>
            </div>
        </div>

        {{-- Botón PDF con aviso --}}
        <div class="mt-6 flex items-start md:items-center gap-4">
            <div class="flex items-center text-sm text-gray-600 bg-blue-50 px-3 py-2 rounded shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z"/>
                </svg>
                Puedes generar un informe en PDF con los datos actuales de las incidencias.
            </div>

            <button onclick="generarPDF()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                📄 Descargar Informe PDF
            </button>
        </div>

        {{-- Tabla para PDF: Oculta pero imprimible --}}
        {{-- TEMPORAL: Ver cuántas incidencias hay :( --}}
        <p>Total incidencias para el PDF: {{ $incidencias->count() }}</p>
        <!-- CAMBIAMOS este style -->
        <div id="areaPdf" style=" display:none">
            <p>{{ isset($incidencias) ? $incidencias->count() : 'no definida' }}</p>
            <div class="p-6">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 60px; margin-bottom: 10px;">
                    <h2 style="font-size: 22px; font-weight: bold;">Informe de Incidencias</h2>
                    <p style="font-size: 14px; color: #666;">Generado: {{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th style="border: 1px solid #ccc; padding: 6px;">Título</th>
                        <th style="border: 1px solid #ccc; padding: 6px;">Estado</th>
                        <th style="border: 1px solid #ccc; padding: 6px;">Prioridad</th>
                        <th style="border: 1px solid #ccc; padding: 6px;">Categoría</th>
                        <th style="border: 1px solid #ccc; padding: 6px;">Usuario</th>
                        <th style="border: 1px solid #ccc; padding: 6px;">Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($incidencias as $i)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ $i->titulo }}</td>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ $i->estado }}</td>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ $i->prioridad }}</td>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ $i->categoria }}</td>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ $i->usuario->nombre ?? 'N/A' }}</td>
                            <td style="border: 1px solid #ddd; padding: 5px;">{{ \Carbon\Carbon::parse($i->fecha_creacion)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.querySelectorAll('.counter').forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = Math.ceil(target / 40);
                if (count < target) {
                    counter.innerText = Math.min(count + increment, target);
                    setTimeout(updateCount, 30);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });

        new Chart(document.getElementById('estadoChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($porEstado->keys()) !!},
                datasets: [{
                    data: {!! json_encode($porEstado->values()) !!},
                    backgroundColor: ['#3b82f6', '#facc15', '#10b981']
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.parsed;
                                let total = context.chart._metasets[0].total || 1;
                                let percentage = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });

        new Chart(document.getElementById('categoriaChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($porCategoria->keys()) !!},
                datasets: [{
                    label: 'Cantidad',
                    data: {!! json_encode($porCategoria->values()) !!},
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ` ${context.raw} incidencias`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function generarPDF() {
            const elemento = document.getElementById("areaPdf");
            if (!elemento) {
                alert("❌ No se encontró el div #areaPdf");
                return;
            }

            console.log("✅ Elemento encontrado, generando PDF...");
            elemento.style.display = "block";

            html2pdf().from(elemento).save();
            setTimeout(function() {
                elemento.style.display = "none";
            }, 500);
            /*elemento.style.visibility = "visible";*/
        }
    </script>
@endsection
