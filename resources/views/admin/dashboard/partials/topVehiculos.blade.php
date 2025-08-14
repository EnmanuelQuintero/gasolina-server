<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow my-6 p-6">
    <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Top 10 Vehículos con Más Kilometraje</h2>
    <table class="min-w-full table-auto text-gray-700 dark:text-gray-300">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm font-semibold">
                <th class="px-6 py-3 text-left">Vehículo</th>
                <th class="px-6 py-3 text-left">Tipo</th>
                <th class="px-6 py-3 text-left">Marca</th>
                <th class="px-6 py-3 text-left">Modelo</th>
                <th class="px-6 py-3 text-right">Kilometraje Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topVehiculosKilometraje as $item)
            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-3 whitespace-nowrap">{{ $item->vehiculo->placa ?? 'N/A' }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $item->vehiculo->tipo ?? 'N/A' }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $item->vehiculo->marcaModelo->marca->nombre ?? 'N/A' }}</td>
                <td class="px-6 py-3 whitespace-nowrap">{{ $item->vehiculo->marcaModelo->modelo->nombre ?? 'N/A' }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-right font-mono">{{ number_format($item->total_kilometros, 2) }} km</td>
            </tr>
            @endforeach
            @if($topVehiculosKilometraje->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay datos disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
