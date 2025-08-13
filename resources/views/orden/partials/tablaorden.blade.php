<table class="min-w-full border border-gray-300 rounded-xl">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="px-4 py-2 text-left">N°</th>
            <th class="px-4 py-2 text-left">Fecha</th>
            <th class="px-4 py-2 text-left">Gasolinera</th>
            <th class="px-4 py-2 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody class="text-gray-800 dark:text-gray-200">
        @foreach ($ordenes as $orden)
            <tr class="bg-white dark:bg-gray-800 border-b hover:bg-gray-50">
                <td class="px-4 py-3">{{ $orden->id }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($orden->fecha)->format('Y-m-d') }}</td>

                <td class="px-4 py-3">{{ $orden->gasolinera->nombre }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap justify-center gap-2">
                        <!-- Ver/Imprimir -->
                        <a href="{{ route('ordenes.detalles', $orden->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg p-2"
                            title="Ver/Imprimir">
                            <img src="{{ asset('/images/iconos/info.png') }}" class="h-4" alt="Ver">
                        </a>

                        @if ($mostrarEntregar)
                            <!-- Entregar -->
                            <a href="{{ route('entrega', $orden->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white rounded-lg p-2"
                                title="Entregar">
                                <img src="{{ asset('/images/iconos/check.png') }}" class="h-4" alt="Entregar">
                            </a>
                        @endif

                        @role('admin')
                            @if ($mostrarEntregar)
                                <!-- Editar -->
                                <a href="{{ route('orden.edit', $orden->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg p-2"
                                    title="Editar">
                                    <img src="{{ asset('/images/iconos/lapiz.png') }}" class="h-4" alt="Editar">
                                </a>
                            @endif
                            <!-- Activar/Eliminar -->
                            <form action="{{ route('orden.estado', $orden->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                @csrf
                                @if ($orden->activo)
                                    <button type="submit" title="Eliminar"
                                        class="bg-red-700 hover:bg-red-800 text-white rounded-lg p-2">
                                        <img src="{{ asset('/images/iconos/basura.png') }}" class="h-4" alt="Eliminar">
                                    </button>
                                @else
                                    <button type="submit" title="Activar"
                                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-2 py-1 text-xs font-bold">
                                        Activar
                                    </button>
                                @endif
                            </form>
                        @endrole
                    </div>
                </td>
            </tr>
            @include('components.orden_imprimir')
        @endforeach
    </tbody>
</table>
