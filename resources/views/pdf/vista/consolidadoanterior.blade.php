@extends('layouts.reportes')

@section('content')

<div class="header mb-4">
    <table class="w-full border-none">
        <tr>
            <td class="w-1/3 text-left border-none">
                <img src="data:image/jpeg;base64,{{ $image }}" alt="" class="w-28 p-2">
            </td>
            <td class="w-1/3 text-center border-none">
                <h1 class="text-4xl font-bold">Alcaldía Municipal de León</h1>
                <p class=" text-xl">{{ $reporte }}</p>
            </td>
            <td class="w-1/3 text-right border-none">
                <img src="data:image/jpeg;base64,{{ $image45 }}" alt="" class="w-28 p-2 float-end">
            </td>
        </tr>
    </table>
</div>

{{$ordenesPorDia}}
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-center">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Fecha Solicitada</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Fecha Descargada</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Orden #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Total Emitido (Litros)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Total Emitido (Galones)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Total Entregado (Litros)</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Total Entregado (Galones)</th>
            </tr>
        </thead>
        @php
            $suma=0;
            $totalSolicitadoL=0;
            $totalDescargadoL=0;
            $totalSolicitadoGal=0;
            $totalDescargadoGal=0;
        @endphp
        <tbody>
            @foreach ($relaciones as $relacion )
                @foreach ($entregadas as $entregada )
                    
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            
                            {{$orden->fecha}}
                            
                        
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{$orden->fecha_entregada}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    
                            {{$orden->id}}
                            
                    
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @foreach ($detalles as $detalle )
                                    
                                    
                                @if ($detalle->id_orden === $orden->id )
                                    @php
                                        if($detalle->medida == 'Litros')
                                        {
                                            $suma+=$detalle->cantidad;
                                        }
                                        else
                                        {
                                            $suma+=$detalle->cantidad * 3.785;
                                        } 
                                    @endphp
            
                                @endif
                            
                            @endforeach
                            {{number_format($suma,2) }} Litros
                            @php
                                $totalSolicitadoL+=$suma;
                                $suma=0;
                            @endphp
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @foreach ($detalles as $detalle )
                                    
                                    
                                @if ($detalle->id_orden === $orden->id )
                                    @php
                                        if($detalle->medida == 'Galones')
                                        {
                                            $suma+=$detalle->cantidad;
                                        }
                                        else
                                        {
                                            $suma+=$detalle->cantidad / 3.785;
                                        }
                                    @endphp
            
                                @endif
                            
                            @endforeach
                            {{number_format($suma,2) }} Galones
                            @php
                                $totalSolicitadoGal+=$suma;
                                $suma=0;
                            @endphp
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"> 
                            @foreach ($detalles as $detalle )
                                    
                                    
                                @if ($detalle->id_orden === $orden->id && $detalle->entregado == 1 )
                                    @php
                                        if($detalle->medida == 'Litros')
                                        {
                                            $suma+=$detalle->cantidad;
                                        }
                                        else
                                        {
                                            $suma+=$detalle->cantidad * 3.785;
                                        } 
                                    @endphp
            
                                @endif
                            
                            @endforeach
                                {{number_format($suma,2) }} Litros
                            @php
                                $medida=$detalle->medida;
                                $totalDescargadoL+=$suma;
                                $suma=0;
                            @endphp
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"> 
                            @foreach ($detalles as $detalle )
                                    
                                    
                                @if ($detalle->id_orden === $orden->id && $detalle->entregado == 1 )
                                    @php
                                        if($detalle->medida == 'Galones')
                                        {
                                            $suma+=$detalle->cantidad;
                                        }
                                        else
                                        {
                                            $suma+=$detalle->cantidad / 3.785;
                                            
                                        }
                                    @endphp
            
                                @endif
                            
                            @endforeach
                                {{number_format($suma,2) }} Galones
                            @php
                                $medida=$detalle->medida;
                                $totalDescargadoGal+=$suma;
                                $suma=0;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            @if ($orden->entregada === 1 && $orden->activo == 1 && $orden->fecha_entregada > $startDate && $orden->fecha_entregada < $endDate )

            @endif
            @endforeach
            <tr class="bg-gray-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><strong>Totales</strong></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($totalSolicitadoL,2) . ' ' . 'Litros'}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($totalSolicitadoGal,2) . ' ' . 'Galones' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($totalDescargadoL,2) . ' ' . 'Litros'}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($totalDescargadoGal,2) . ' ' . 'Galones' }}</td>
            </tr>
        </tbody>

    </table>
</div>

@endsection