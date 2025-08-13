@extends('layouts.dash')

@section('content')

<div class="grid md:grid-cols-2 grid-cols-1 gap-8">
    <div class="w-full flex justify-center items-center">
        @include('vehiculo.partials.modalCrear')
    </div>

    <div class="w-full flex justify-center items-center">
        @include('vehiculo.partials.modalCrearVehiculo')
    </div>
</div>

<div class="mt-10">
    <!-- Filtros y búsqueda -->
<form action="{{ route('modelos-vehiculos.index') }}" method="GET" class="mb-4 flex flex-wrap items-center gap-4">
    <input type="text" name="placa" value="{{ request('placa') }}" placeholder="Buscar por placa"
        class="px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

    <select name="tipo" class="px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">Todos los tipos</option>
        <option value="Sedan" {{ request('tipo') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
        <option value="Camion" {{ request('tipo') == 'Camion' ? 'selected' : '' }}>Camion</option>
        <option value="Moto" {{ request('tipo') == 'Moto' ? 'selected' : '' }}>Moto</option>
        <option value="Camioneta" {{ request('tipo') == 'Camioneta' ? 'selected' : '' }}>Camioneta</option>
    </select>

    <select name="color" class="px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">Todos los colores</option>
        @foreach(['Blanco', 'Negro', 'Gris', 'Plateado', 'Azul', 'Rojo', 'Verde', 'Morado', 'Amarillo', 'Naranja'] as $color)
            <option value="{{ $color }}" {{ request('color') == $color ? 'selected' : '' }}>{{ $color }}</option>
        @endforeach
    </select>
    <select name="estado" class="px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">Todos los estados</option>
        <option value="operativo" {{ request('estado') == 'operativo' ? 'selected' : '' }}>Operativo</option>
        <option value="taller" {{ request('estado') == 'taller' ? 'selected' : '' }}>En taller</option>
        <option value="baja" {{ request('estado') == 'baja' ? 'selected' : '' }}>De baja</option>
    </select>

    <button type="submit"
        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200">
        Buscar
    </button>
</form>

    @include('vehiculo.partials.tabla')
</div>


@endsection

