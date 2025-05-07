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
                <p class="text-xl font-bold counter" data-target="{{ $porEstado['Abierta'] ?? 0 }}">0</p>
            </div>
            <div class="bg-white rounded shadow p-4 text-center">
                <p class="text-sm text-gray-500">Cerradas</p>
                <p class="text-xl font-bold counter" data-target="{{ $porEstado['Cerrada'] ?? 0 }}">0</p>
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

        {{-- Botón para generar PDF --}}
        <div class="mt-6">
            <button onclick="generarPDF()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                📄 Descargar Informe PDF
            </button>
        </div>

        {{-- Contenido oculto para PDF --}}
        <div id="areaPdf" class="hidden">
            {{-- Si necesitas meter contenido real aquí para el PDF, hazlo luego --}}
        </div>
    </div>

    {{-- Chart.js --}}
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

    {{-- html2pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function generarPDF() {
            const element = document.getElementById('areaPdf');
            html2pdf().from(element).set({
                margin: 0.5,
                filename: 'informe_incidencias.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            }).save();
        }
    </script>
@endsection
