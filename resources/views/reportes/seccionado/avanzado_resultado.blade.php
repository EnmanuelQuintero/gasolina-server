@extends('layouts.dash')

@section('content')
<form action="{{ route('reporte.avanzado.pdf') }}" method="POST" target="_blank">
    @csrf
    <!-- campos: fecha_inicio, fecha_fin, filtro y los campos extra según el filtro -->
    <button type="submit">Descargar PDF</button>
</form>

@include('reportes.seccionado.pdf')
@endsection
