@extends('layouts.dash')
@section('content')

<div class="max-w-6xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow">

    <h1 class="text-3xl font-bold mb-6 text-center dark:text-white">Listado de Órdenes</h1>

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
