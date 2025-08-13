@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Reporte Especifico de Órdenes</h2>
    <form action="/reportes/avanzado/ver" method="POST">
        @csrf

        {{-- Fecha Inicio --}}
        <div class="mb-4">
            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        {{-- Fecha Fin --}}
        <div class="mb-4">
            <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        {{-- Filtro --}}
        <div class="mb-4">
            <label for="filtro" class="block text-sm font-medium text-gray-700">Filtrar por</label>
            <select name="filtro" id="filtro"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                required>
                <option value="">Seleccione un filtro</option>
                <option value="gasolinera">Gasolinera</option>
                <option value="persona">Chofer</option>
                <option value="vehiculo">Vehículo</option>
            </select>
        </div>

        {{-- Selector dinámico (gasolinera/persona/vehiculo) --}}
        <div id="opciones-filtro" class="mb-4"></div>

        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Generar Reporte
        </button>
    </form>
</div>

{{-- Script para cargar el filtro dinámico --}}
<script>
    document.getElementById('filtro').addEventListener('change', function () {
        const tipo = this.value;
        const contenedor = document.getElementById('opciones-filtro');
        contenedor.innerHTML = '';

        if (tipo !== '') {
            fetch(`/reportes/opciones/${tipo}`)
                .then(res => res.text())
                .then(html => contenedor.innerHTML = html)
                .catch(() => contenedor.innerHTML = '<p class="text-red-500 text-sm">Error al cargar opciones.</p>');
        }
    });
</script>
@endsection
