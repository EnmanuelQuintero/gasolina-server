@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-2xl">
    <h1 class="text-2xl font-bold mb-6 text-center">Generar Reporte de Órdenes</h1>

    <form method="POST" action="{{ route('reportes.ver') }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" class="w-full border rounded px-4 py-2" required>
            </div>
            <div>
                <label class="block font-semibold">Fecha Fin</label>
                <input type="date" name="fecha_fin" class="w-full border rounded px-4 py-2" required>
            </div>
        </div>
        <div class="flex gap-4 mt-6 justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Ver Reporte</button>
        </div>
    </form>
</div>
@endsection
