@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Entrega</h1>
    <form action="{{ route('entregas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="id_detalle">Detalle</label>
            <select class="form-control" id="id_detalle" name="id_detalle" required>
                @foreach($detalles as $detalle)
                    <option value="{{ $detalle->id }}">Numero:{{ $detalle->id }} Fecha:{{ $detalle->fecha }}</option> <!-- Cambia 'some_field' por el campo que quieras mostrar -->
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="entregado">Entregado</label>
            <select class="form-control" id="entregado" name="entregado" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="activo">Activo</label>
            <select class="form-control" id="activo" name="activo" required>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
