@extends('layouts.dash')

@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-semibold mb-6 text-black dark:text-white">Editar Cargo</h1>

    <form action="{{ str_replace('dummy', $dato->id, $ruta) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nombre" class="block text-lg font-medium text-black dark:text-white">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ $dato->nombre }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        </div>

        @if ($nombre_tabla == "Gasolineras")
            <div class="mb-4">
                <label for="nombre" class="block text-lg font-medium text-black dark:text-white">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="{{ $dato->direccion }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            
        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Actualizar
        </button>
    </form>
</div>
@endsection