@extends('layouts.dash')

@section('content')
<form action="{{ route('reportes.avanzado.pdf') }}" method="POST">
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

    <button type="submit">Descargar PDF</button>
</form>


@include('reportes.seccionado.vista')
@endsection
