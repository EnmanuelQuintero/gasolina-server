@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Entrega de detalles para Orden #{{ $orden->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Vehículo</th>
                <th>Kilometros</th>
                <th>Chofer</th>
                <th>Combustible</th>
                <th>Cantidad</th>
                <th>Medida</th>
                <th>Entregado</th>
                <th>Fecha Entrega</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relaciones as $relacion)
                <tr>
                    <td>{{ $relacion->detalleOrden->vehiculo->nombre ?? 'N/A' }}</td>
                    <td>{{ $relacion->detalleOrden->kilometros ?? 'N/A' }}</td>
                    <td>{{ $relacion->detalleOrden->chofer->primer_nombre ?? 'N/A' }}</td>
                    <td>{{ $relacion->detalleOrden->combustible->nombre ?? 'N/A' }}</td>
                    <td>{{ $relacion->detalleOrden->cantidad }}</td>
                    <td>{{ $relacion->detalleOrden->medida }}</td>
                    <td>
                        @if($relacion->entregado)
                            <span class="badge bg-success">Sí</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>{{ $relacion->fecha_entrega ?? '---' }}</td>
                    <td>
                        @if(!$relacion->entregado)
                            <form method="POST" action="{{ route('entrega.detalle', $relacion->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Entregar</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-success" disabled>Entregado</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection