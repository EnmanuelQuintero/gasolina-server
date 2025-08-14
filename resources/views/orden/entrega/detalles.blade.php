@extends('layouts.dash')

@section('content')
<a href="{{route('orden.index')}}">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
    Atras
    </button>
</a>

<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Entrega de Detalles para la Orden #{{ $orden->id }}</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('entrega.multiple') }}">
        @csrf

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow-md text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">Seleccionar</th>
                        <th class="px-4 py-2 text-left">Vehículo</th>
                        <th class="px-4 py-2 text-left">Kiometros</th>
                        <th class="px-4 py-2 text-left">Chofer</th>
                        <th class="px-4 py-2 text-left">Combustible</th>
                        <th class="px-4 py-2 text-left">Cantidad</th>
                        <th class="px-4 py-2 text-left">Medida</th>
                        <th class="px-4 py-2 text-left">Entregado</th>
                        <th class="px-4 py-2 text-left">Fecha Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relaciones as $relacion)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                @if(!$relacion->entregado && $relacion->detalleOrden->vehiculo->estado == 'operativo')
                                    <input type="checkbox" name="detalles[]" value="{{ $relacion->id }}" class="form-checkbox h-4 w-4 text-indigo-600">
                                @endif
                            </td>
                            
                            @if($relacion->detalleOrden->vehiculo->estado == 'operativo')
                                <td class="px-4 py-2">
                                    {{ $relacion->detalleOrden->vehiculo->placa ?? 'N/A' }}
                                </td>
                            @else
                                <td class="px-4 py-2 bg-red-200">
                                    {{ $relacion->detalleOrden->vehiculo->placa ?? 'N/A' }} - 
                                    Estado: {{ $relacion->detalleOrden->vehiculo->estado }}
                                </td>
                            @endif
                            <td class="px-4 py-2">{{ $relacion->detalleOrden->kilometros ?? '' }}</td>
                            <td class="px-4 py-2">{{ $relacion->detalleOrden->chofer->primer_nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $relacion->detalleOrden->combustible->nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $relacion->detalleOrden->cantidad }}</td>
                            <td class="px-4 py-2">{{ $relacion->detalleOrden->medida }}</td>
                            <td class="px-4 py-2">
                                @if($relacion->entregado)
                                    <span class="inline-flex px-2 py-1 bg-green-200 text-green-800 text-xs rounded">Sí</span>
                                @else
                                    <span class="inline-flex px-2 py-1 bg-gray-200 text-gray-600 text-xs rounded">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $relacion->fecha_entrega ?? '---' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded disabled:opacity-50"
                onclick="return confirm('¿Estás seguro de entregar los detalles seleccionados?')"
            >
                Marcar como Entregados
            </button>
        </div>
    </form>
</div>
@endsection
