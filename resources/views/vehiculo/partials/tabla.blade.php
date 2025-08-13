<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 rounded-xl divide-y divide-gray-200 dark:divide-gray-600 dark:bg-gray-800">
        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
            <tr>
                <th class="px-4 py-2 text-left">Placa</th>
                <th class="px-4 py-2 text-left">Tipo</th>
                <th class="px-4 py-2 text-left">Color</th>
                <th class="px-4 py-2 text-left">Marca</th>
                <th class="px-4 py-2 text-left">Estado</th> <!-- Nueva columna -->
                <th class="px-4 py-2 text-left">Modelo / Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            @forelse ($vehiculos as $vehiculo)
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-4 py-2 border-b border-gray-300">{{ $vehiculo->placa }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $vehiculo->tipo }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $vehiculo->color }}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{ $vehiculo->marcaModelo->marca->nombre ?? '—' }}</td>
                    <td class="px-4 py-2 border-b border-gray-300 capitalize">
                        {{ $vehiculo->estado }}
                    </td>
                    <td class="px-4 py-2 border-b border-gray-300">
                        <div class="flex items-center justify-between gap-4">
                            <!-- Modelo -->
                            <span>{{ $vehiculo->marcaModelo->modelo->nombre ?? '—' }}</span>

                            <!-- Botón editar (modal) -->
                            @include('vehiculo.partials.modalEditarVehiculo')

                            <!-- Botón activar/desactivar -->
                            <div class="relative group">
                                <button onclick="toggleActivo({{ $vehiculo->id }})"
                                        class="flex items-center justify-center p-2.5 {{ $vehiculo->activo ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700' }} rounded-xl hover:rounded-3xl transition-all duration-300 text-white">
                                    <span class="material-symbols-outlined">
                                        {{ $vehiculo->activo ? 'visibility' : 'visibility_off' }}
                                    </span>
                                </button>
                                <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-32 hidden group-hover:block bg-white text-black text-xs rounded-md p-2 shadow-lg z-10">
                                    Oculta el registro
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">No hay vehículos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
