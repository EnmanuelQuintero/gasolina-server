@extends('layouts.dash')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-2xl">

    <h1 class="text-2xl font-bold mb-4 text-center">Resultados del Reporte</h1>

    <div class="mb-6 flex justify-end gap-4">
        <form action="{{ route('reportes.pdf') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Descargar PDF</button>
        </form>

        <form action="{{ route('reportes.excel') }}" method="POST">
            @csrf
            <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Descargar Excel</button>
        </form>
    </div>

    @include('reportes.pdf')
</div>
@endsection
