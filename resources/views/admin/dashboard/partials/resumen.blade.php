<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Combustible consumido -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-md transition">
        <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Total Combustible Consumido</h2>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $combustibleConsumido }} Lts</p>
    </div>

    <!-- Vehículos activos -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-md transition">
        <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Vehículos Activos</h2>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $vehiculosActivos }}</p>
    </div>

    <!-- Fecha actual -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-md transition">
        <h2 class="text-lg font-semibold text-gray-600 dark:text-gray-300">Fecha</h2>
        <p class="text-3xl font-bold text-gray-700 dark:text-gray-300 mt-2">{{ now()->format('d/m/Y') }}</p>
        <span id="reloj" class="text-lg font-semibold text-gray-600 dark:text-gray-300"></span>
    </div>
</div>