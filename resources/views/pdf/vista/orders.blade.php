@extends('layouts.reportes')

@section('content')

<header class="bg-white shadow-md mb-4">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <img src="data:image/jpeg;base64,{{ $image }}" alt="Logo izquierdo" class="w-16 h-auto">
                <div class="text-center">
                    <h1 class="text-xl font-semibold">Alcaldía Municipal de León</h1>
                    <p class="text-sm">{{ $reporte }}</p>
                </div>
                <img src="data:image/jpeg;base64,{{ $image45 }}" alt="Logo derecho" class="w-16 h-auto">
            </div>
        </div>
    </header>

    <main class="w-full mx-auto px-4 py-6">
        @if ($orders->isEmpty())
            <p class="text-center text-gray-600">No hay datos para mostrar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            @foreach(['Orden #', 'Fecha de creación', 'Fecha de Entrega', 'Gasolinera', 'Autorizado por', 'Área Autorizado', 'Cargo Autorizado', 'Número de Placa', 'Tipo Vehículo', 'Marca Vehículo', 'Modelo Vehículo', 'Color Vehículo', 'Chofer', 'Cargo Chofer', 'Combustible', 'Cantidad (Litros)', 'Cantidad (Galones)'] as $header)
                                <th class="px-4 py-2 border-b">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($orders as $order)
                            @foreach ($order->detalles as $detalle)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $order->id }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->fecha }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->fecha_entregada ?? 'Sin entregar' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->gasolinera->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->autorizado->primer_nombre . ' ' . $order->autorizado->primer_apellido ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->autorizado->area->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $order->autorizado->cargo->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->vehiculo->placa ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->vehiculo->tipo ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->vehiculo->marca->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->vehiculo->modelo->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->vehiculo->color ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->chofer->primer_nombre . ' ' . $detalle->chofer->primer_apellido ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->chofer->cargo->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $detalle->combustible->nombre ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b">
                                        @if ($detalle->medida == 'Litros')
                                            {{ $detalle->cantidad }} L
                                        @else
                                            {{ number_format($detalle->cantidad * 3.785,2) }} L
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @if ($detalle->medida == 'Galones')
                                            {{ $detalle->cantidad }} gal
                                        @else
                                            {{ number_format($detalle->cantidad / 3.785,2) }} gal
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

@endsection