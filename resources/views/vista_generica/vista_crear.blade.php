@extends('layouts.dash')

@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-semibold mb-6">Crear registro de {{$nombre}}</h1>

    <form action="{{$ruta_store }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-plus"></i> Crear
        </button>
    </form>
</div>
@endsection
