@extends('layouts.dash')
@section('content')
    <!-- Botón flotante circular -->
    <a href="{{ route('orden.create') }}"
    class="fixed bottom-6 right-6 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800"
    data-popover-target="popover-crear-orden"
    type="button"
    title="Crear Nueva Orden">
    <!-- Ícono de más -->
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
    </svg>
    </a>


<div class="max-w-6xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">

    <h1 class="text-3xl font-bold mb-6 text-center dark:text-white">Listado de Órdenes</h1>
    <form action="{{ route('orden.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mt-6">
        <!-- Token -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Token</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Buscar por token">
        </div>

        <!-- Filtro por gasolinera -->
        <div>
            <label for="gasolinera" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gasolinera</label>
            <select name="gasolinera" id="gasolinera"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Todas</option>
                @foreach($gasolineras as $gasolinera)
                    <option value="{{ $gasolinera->id }}" {{ request('gasolinera') == $gasolinera->id ? 'selected' : '' }}>
                        {{ $gasolinera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>



        <!-- Fecha -->
        <div>
            <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>

        <!-- Botón -->
        <div>
            <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                Buscar
            </button>
        </div>
    </form>


    <!-- Pestañas -->
    <div class="flex border-b border-gray-300 dark:border-gray-600 mb-4">
        <button id="tab-pendientes" class="px-4 py-2 text-blue-600 border-b-2 border-blue-600 focus:outline-none">Pendientes</button>
        <button id="tab-entregadas" class="px-4 py-2 text-gray-600 hover:text-blue-600 focus:outline-none">Entregadas</button>
    </div>

    <!-- Tabla de pendientes -->
    <div id="content-pendientes">
        @include('orden.partials.tablaorden', ['ordenes' => $pendientes, 'mostrarEntregar' => true])
    </div>

    <!-- Tabla de entregadas -->
    <div id="content-entregadas" class="hidden">
        @include('orden.partials.tablaorden', ['ordenes' => $entregadas, 'mostrarEntregar' => false])
    </div>

</div>

<script>
document.getElementById('tab-pendientes').addEventListener('click', function() {
    document.getElementById('tab-pendientes').classList.add('text-blue-600', 'border-blue-600');
    document.getElementById('tab-entregadas').classList.remove('text-blue-600', 'border-blue-600');
    document.getElementById('content-pendientes').classList.remove('hidden');
    document.getElementById('content-entregadas').classList.add('hidden');
});

document.getElementById('tab-entregadas').addEventListener('click', function() {
    document.getElementById('tab-entregadas').classList.add('text-blue-600', 'border-blue-600');
    document.getElementById('tab-pendientes').classList.remove('text-blue-600', 'border-blue-600');
    document.getElementById('content-entregadas').classList.remove('hidden');
    document.getElementById('content-pendientes').classList.add('hidden');
});
</script>

@endsection
