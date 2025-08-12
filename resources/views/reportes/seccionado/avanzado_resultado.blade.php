@extends('layouts.dash')

@section('content')
<form action="{{ route('reportes.avanzado.pdf') }}" method="POST" class="mb-6">
    @csrf
    <input type="hidden" name="fecha_inicio" value="{{ $request->fecha_inicio }}">
    <input type="hidden" name="fecha_fin" value="{{ $request->fecha_fin }}">
    <input type="hidden" name="filtro" value="{{ $filtro }}">

    @if($filtro === 'gasolinera')
        <input type="hidden" name="gasolinera_id" value="{{ $request->gasolinera_id }}">
    @elseif($filtro === 'persona')
        <input type="hidden" name="persona_id" value="{{ $request->persona_id }}">
    @elseif($filtro === 'vehiculo')
        <input type="hidden" name="vehiculo_id" value="{{ $request->vehiculo_id }}">
    @endif

    <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-md flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z"></path>
            </svg>
            <span class="font-medium">¿Deseas descargar este reporte en PDF?</span>
        </div>

        <button type="submit"
                class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 ml-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v16m8-8H4"></path>
            </svg>
            Descargar PDF
        </button>
    </div>
</form>



@include('reportes.seccionado.vista')
@endsection
