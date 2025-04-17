@extends('layouts.dash')

@section('content')
<div class="container">
    <h1>Listado de Entregas</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route('entregas.create') }}" class="btn btn-primary mb-3">Nueva Entrega</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Detalle</th>
                <th>Entregado</th>
                <th>Activo</th>
                <th>Acciones</th>
                <th>QR Code</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relacionDetalleOrden as $entrega)
                <tr>
                    <td>{{ $entrega->id }}</td>
                    <td>{{ $entrega->fecha }}</td>
                    <td>{{ $entrega->detalleOrden->some_field ?? 'N/A' }}</td> <!-- Cambia 'some_field' por el campo que quieras mostrar -->
                    <td>{{ $entrega->entregado ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrega->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <!-- Botón de entrega -->
                        @if(!$entrega->entregado)
                            <form action="{{ route('entregas.entregar', $entrega->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Marcar como Entregado</button>
                            </form>
                        @else
                            <span>Ya entregado</span>
                        @endif
                        
                        <!-- Botón de editar -->
                        <a href="{{ route('entregas.edit', $entrega->id) }}" class="btn btn-warning btn-sm">Editar</a>

                        <!-- Botón de eliminar -->
                        <form action="{{ route('entregas.destroy', $entrega->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta entrega?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
