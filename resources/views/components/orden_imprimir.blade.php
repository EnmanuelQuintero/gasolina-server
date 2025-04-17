@php
    $detallesPorPagina = 11; // Máximo 11 detalles por página
    $paginaActual = request()->get('page', 1); // Obtiene la página actual, por defecto es la primera
    $detallesPaginados = $detalles->forPage($paginaActual, $detallesPorPagina); // Pagina los detalles
    $totalPaginas = ceil($detalles->count() / $detallesPorPagina); // Calcula el total de páginas
@endphp

<div id="modalDetalles{{ $orden->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 text-white">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 w-1/2" id="imprimir">
        <div class="m-4 w-full">
            <button type="button" class="absolute mb-4 top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modalDetalles{{ $orden->id }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="sr-only">Cerrar</span>
            </button>
        </div>

        <!-- Contenido del modal -->
        <div class="grid grid-cols-6 auto-rows-max max-w-max text-center tabla">
            <!-- Columna para numeración -->
            <div class="columna">
                <div class="encabezado">
                    <p>#</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $loop->iteration + (($paginaActual - 1) * $detallesPorPagina) }}</p>
                    @endif
                @endforeach
            </div>

            <!-- Columna para Tipo de Vehículo -->
            <div class="columna">
                <div class="encabezado">
                    <p>Tipo de Vehículo</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->vehiculo->tipo }}</p>
                    @endif
                @endforeach
            </div>

            <!-- Columna para Modelo -->
            <div class="columna">
                <div class="encabezado">
                    <p>Modelo</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->vehiculo->modelo->nombre }}</p>
                    @endif
                @endforeach
            </div>

            <!-- Columna para Placa -->
            <div class="columna">
                <div class="encabezado">
                    <p>Placa</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->vehiculo->placa }}</p>
                    @endif
                @endforeach
            </div>

            <!-- Columna para Cantidad -->
            <div class="columna">
                <div class="encabezado">
                    <p>Cantidad</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->cantidad }}</p>
                    @endif
                @endforeach
            </div>

                        <!-- Columna para Cantidad -->
            <div class="columna">
                <div class="encabezado">
                    <p>Cantidad</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->cantidad }}</p>
                    @endif
                @endforeach
            </div>


            <!-- Columna para Total -->
            <div class="columna">
                <div class="encabezado">
                    <p>Total</p>
                </div>
                @foreach ($detallesPaginados as $detalle)
                    @if ($detalle->id_orden === $orden->id)
                        <p>{{ $detalle->total }}</p>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Paginación -->
        <div class="flex justify-between items-center mt-4">
            <span>Mostrando página {{ $paginaActual }} de {{ $totalPaginas }}</span>
            <div>
                @if ($paginaActual > 1)
                    <a href="?page={{ $paginaActual - 1 }}" class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-900">Anterior</a>
                @endif
                @if ($paginaActual < $totalPaginas)
                    <a href="?page={{ $paginaActual + 1 }}" class="px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-900">Siguiente</a>
                @endif
            </div>
        </div>

        <!-- Botón para imprimir -->
        <button onclick="imprimir('modalDetalles{{ $orden->id }}')" class="float-end text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Imprimir Factura</button>
    </div>
</div>
