@extends('layouts.dash')

@section('content')

@if(session('error'))

    <div id="toast-error" class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 text-white bg-red-500 rounded-lg shadow-lg dark:bg-red-600" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-white rounded-lg dark:text-red-200 dark:bg-red-700">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 102 0V7zm-1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div class="ml-3 text-sm font-normal">{{ session('error') }}</div>
        <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 dark:hover:bg-red-700 dark:bg-red-800 dark:text-red-200 dark:hover:text-white" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <script>
        function closeToast() {
            document.getElementById('toast-error').style.display = 'none';
        }
    </script>
@endif

    @include('admin.partials.datosSuperior')
    @include('admin.partials.graficos')

    <script>
    const ctx = document.getElementById('ordenesChart').getContext('2d');
    const ordenesChart = new Chart(ctx, {
        type: 'bar', // Cambia a 'line' o 'pie' según tus preferencias
        data: {
            labels: ['Órdenes Solicitadas', 'Órdenes Entregadas'],
            datasets: [{
                label: 'Cantidad de Órdenes',
                data: [{{ $conteoOrdenesSolicitadas }}, {{ $conteoOrdenesEntregadas }}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    const ctxDia = document.getElementById('ordenesPorDiaChart').getContext('2d');
    const ordenesPorDiaChart = new Chart(ctxDia, {
        type: 'bar', // Cambiar a gráfico de barras
        data: {
            labels: {!! json_encode($diasSolicitados) !!}, // Días de las órdenes solicitadas
            datasets: [
                {
                    label: 'Órdenes Solicitadas',
                    data: {!! json_encode($totalesSolicitados) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Color de fondo para las órdenes solicitadas
                    borderColor: 'rgba(75, 192, 192, 1)', // Color del borde para las órdenes solicitadas
                    borderWidth: 1
                },
                {
                    label: 'Órdenes Entregadas',
                    data: {!! json_encode($totalesEntregados) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.5)', // Color de fondo para las órdenes entregadas
                    borderColor: 'rgba(153, 102, 255, 1)', // Color del borde para las órdenes entregadas
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    const ctxCombustible = document.getElementById('combustibleChart').getContext('2d');
    const combustibleChart = new Chart(ctxCombustible, {
        type: 'bar', // Cambia el tipo a 'bar' para un gráfico de barras
        data: {
            labels: ['Litros Solicitados', 'Galones Solicitados', 'Litros Entregados', 'Galones Entregados'],
            datasets: [
                {
                    label: 'Combustible Solicitado',
                    data: [{{ $litrosSolicitados }}, {{ $galonesSolicitados }}, 0, 0], // Solo los solicitados
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Azul claro
                    borderColor: 'rgba(54, 162, 235, 1)', // Azul claro
                    borderWidth: 1
                },
                {
                    label: 'Combustible Entregado',
                    data: [0, 0, {{ $litrosEntregados }}, {{ $galonesEntregados }}], // Solo los entregados
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Rojo
                    borderColor: 'rgba(255, 99, 132, 1)', // Rojo
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    const ctxCombustiblePorDia = document.getElementById('combustiblePorDiaChart').getContext('2d');
    const combustiblePorDiaChart = new Chart(ctxCombustiblePorDia, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_unique(array_merge($diasCombustibleSolicitado, $diasCombustibleEntregado))) !!}, // Combina los días
            datasets: [
                {
                    label: 'Litros Solicitados',
                    data: {!! json_encode(array_merge($litrosSolicitadosPorDia, array_fill(0, count($diasCombustibleSolicitado), 0))) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Azul claro
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Galones Solicitados',
                    data: {!! json_encode(array_merge($galonesSolicitadosPorDia, array_fill(0, count($diasCombustibleSolicitado), 0))) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.5)', // Verde claro
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Litros Entregados',
                    data: {!! json_encode(array_merge($litrosEntregadosPorDia, array_fill(0, count($diasCombustibleEntregado), 0))) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Rojo
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Galones Entregados',
                    data: {!! json_encode(array_merge($galonesEntregadosPorDia, array_fill(0, count($diasCombustibleEntregado), 0))) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.5)', // Morado
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

