<div class="grid grid-cols-1 mx-8 md:grid-cols-2 gap-8 mb-8">
        {{-- Gráfico de consumo mensual --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Consumo Mensual de Combustible</h2>
            <canvas id="consumoChart" height="100"></canvas>
        </div>

        {{-- Gráfico pastel de combustible solicitado vs entregado --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Solicitado vs Entregado</h2>
            <canvas id="combustiblePieChart" height="100"></canvas>
        </div>
    </div>