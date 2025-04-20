@extends('layouts.dash')

@section('content')

<div class="container mx-auto p-6 dark:bg-gray-900 dark:text-white">

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center dark:text-white">
        <span class="mr-4">Dashboard - Control de Combustible</span> 
        
    </h1>
    <a href="{{ route('reportes.avanzado.form') }}" class="btn btn-success">
        <i class="fas fa-filter"></i> Reporte Avanzado
    </a>

    <a href="{{ route('reportes.index') }}"
        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
        📄 Ver Reportes de Órdenes
    </a>

    {{-- Tarjetas de resumen --}}
    @include('admin.dashboard.partials.resumen')

    {{-- Graficos --}}
    @include('admin.dashboard.partials.graficos')

    {{-- Últimas cargas --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow my-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Últimos Registros de Carga</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Vehículo</th>
                        <th class="px-4 py-2">Chofer</th>
                        <th class="px-4 py-2">Combustible</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Gasolinera</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimasCargas as $carga)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $carga->vehiculo->placa ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $carga->chofer->primer_nombre ?? 'N/A' }} {{ $carga->chofer->primer_apellido ?? '' }}</td>
                            <td class="px-4 py-2">{{ $carga->combustible->nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $carga->cantidad }} {{ $carga->medida }}</td>
                            <td class="px-4 py-2">
                                {{ $carga->ordenes->first()->gasolinera->nombre ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>


{{-- Script de Chart.js para el gráfico --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const pieCtx = document.getElementById('combustiblePieChart').getContext('2d');
    const combustiblePieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Solicitado', 'Entregado'],
            datasets: [{
                data: [{{ $combustibleSolicitado }}, {{ $combustibleEntregado }}],
                backgroundColor: ['#f59e0b', '#10b981'], // Amarillo y Verde
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' Lts';
                        }
                    }
                }
            }
        }
    });
</script>
<script>
    function actualizarReloj() {
        const fecha = new Date();
        const horas = fecha.getHours().toString().padStart(2, '0');
        const minutos = fecha.getMinutes().toString().padStart(2, '0');
        const segundos = fecha.getSeconds().toString().padStart(2, '0');
        
        // Formato HH:MM:SS
        const horaFormateada = `${horas}:${minutos}:${segundos}`;
        
        // Actualiza el reloj en la página
        document.getElementById('reloj').innerText = horaFormateada;
    }

    // Actualizar cada segundo
    setInterval(actualizarReloj, 1000);
    
    // Inicializar el reloj
    actualizarReloj();
</script>
<script>
    const ctx = document.getElementById('consumoChart').getContext('2d');
    const consumoChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico de barras (horizontal)
        data: {
            labels: {!! json_encode(array_map(fn($mes) => \Carbon\Carbon::create()->month($mes)->format('F'), array_keys($consumoMensual->toArray()))) !!}, // Etiquetas de meses
            datasets: [{
                label: 'Litros consumidos', // Título de la serie de datos
                data: {{ json_encode(array_values($consumoMensual->toArray())) }}, // Datos de consumo mensual
                backgroundColor: '#3b82f6' // Color de fondo de las barras
            }]
        },
        options: {
            indexAxis: 'y', // Cambiar la orientación a barras horizontales
            scales: {
                x: {
                    beginAtZero: true, // Comienza en 0 en el eje x
                    ticks: {
                        callback: function(value) {
                            return value + ' Lts'; // Añadir "Lts" a las etiquetas de los ticks
                        }
                    }
                }
            }
        }
    });
</script>


@endsection