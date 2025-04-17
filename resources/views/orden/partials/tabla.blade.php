
<table id="filter-table" class="min-w-full border border-gray-300 rounded-xl">
    <thead>
        <tr>
            <th>
                <span class="flex items-center">
                    N°
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Fecha
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Gasolinera
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
            <th>
                <span class="flex items-center">
                    Acciones
                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                    </svg>
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ordenes as $orden)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-4 py-4 w-auto">{{ $orden->id }}</td>
                <td class="px-4 py-4 w-auto">{{ $orden->fecha }}</td>
                <td class="px-4 py-4 w-auto">{{ $orden->gasolinera->nombre }}</td>
                
                <td class="px-4 py-4 w-auto text-center grid grid-cols-4">
                    @role('admin')
                        <div class="md:flex md:justify-center inline mt-4">
                            <!-- Botón Editar -->
                            <a href="{{ route('orden.edit', $orden->id) }}" class="text-xs font-bold bg-blue-500 text-white rounded-lg py-2 px-4 shadow-md hover:bg-blue-600" data-popover-target="popover-editar-{{$orden->id}}" type="button">
                                <img src="{{asset('/images/iconos/lapiz.png')}}" class="h-4" alt="Editar">
                            </a>
                            <div data-popover id="popover-editar-{{$orden->id}}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Editar Orden</h3>
                                </div>
                                <div class="px-3 py-2">
                                    <p>Haz clic para editar los detalles de esta orden.</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>

                        <!-- Botón Eliminar -->
                        @if ($orden->activo)
                            <form action="{{ route('orden.estado', $orden->id) }}" method="POST" class="inline-block mt-4">
                                @csrf
                                <button type="submit" class="text-xs font-bold bg-red-700 text-white rounded-lg py-2 px-4 shadow-md hover:bg-red-800" onclick="return confirm('¿Estás seguro de que quieres eliminar esta orden?')" data-popover-target="popover-eliminar-{{$orden->id}}" type="button">
                                    <img src="{{asset('/images/iconos/basura.png')}}" class="h-4" alt="Eliminar">
                                </button>
                                <div data-popover id="popover-eliminar-{{$orden->id}}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Eliminar Orden</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Haz clic para eliminar esta orden.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('orden.estado', $orden->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="text-xs font-bold bg-orange-500 text-white mt-4 rounded-lg py-2 px-4 shadow-md hover:bg-orange-600" onclick="return confirm('¿Estás seguro de que quieres activar esta orden?')">Activar</button>
                            </form>
                        @endif
                    @endrole

                    <div class="md:flex md:justify-center">
                        <!-- Botón Ver/Imprimir -->
                        <a href="{{ route('ordenes.detalles', $orden->id) }}" class="text-xs mt-4 font-bold bg-blue-500 text-white rounded-lg py-2 px-4 shadow-md hover:bg-blue-600" data-popover-target="popover-detalles-{{$orden->id}}" type="button">
                            <img src="{{asset('/images/iconos/info.png')}}" class="h-4" alt="Ver/Imprimir">
                        </a>
                        <div data-popover id="popover-detalles-{{$orden->id}}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Ver/Imprimir Orden</h3>
                            </div>
                            <div class="px-3 py-2">
                                <p>Haz clic para ver o imprimir los detalles de esta orden.</p>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                    </div>

                    <div class="md:flex md:justify-center mt-4">
                        <!-- Botón Entregar -->
                        <a href="{{ route('entrega', $orden->id) }}" class="text-xs font-bold bg-green-500 text-white rounded-lg py-2 px-4 shadow-md hover:bg-green-600" data-popover-target="popover-entregar-{{$orden->id}}" type="button">
                            <img src="{{asset('/images/iconos/check.png')}}" class="h-4" alt="Entregar">
                        </a>
                        <div data-popover id="popover-entregar-{{$orden->id}}" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                            <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Entregar Orden</h3>
                            </div>
                            <div class="px-3 py-2">
                                <p>Haz clic para marcar esta orden como entregada.</p>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                    </div>
                </td>

            </tr>
            @include('components.orden_imprimir')
        @endforeach
    </tbody>
</table>
