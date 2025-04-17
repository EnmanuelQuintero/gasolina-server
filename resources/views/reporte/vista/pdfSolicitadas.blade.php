@extends('layouts.reportes')

@section('content')
<div style="display:flex; flex-direction:column;">


<table style="border: none">
    <thead >
        <tr style="border: none;">
            <th style="border: none">
                <img src="{{ asset('/images/logo.png') }}" alt="" style="height: 80px">
            </th>
            <th colspan="7" style="text-align: center; border: none;">
                <div style="font-size:25px; font-weight:bold; ">
                    Alcaldia Municipal de Leon <br>
                </div>
                <div style="font-size:20px; font-weight:lighter;">
                    Reporte de Ordenes Solicitadas <br>
                </div>
                <div style="font-size: 15px; font-weight:lighter;">
                    {{ $startDate }} al {{ $endDate }}
                </div>
                
            </th>
            <th style="border: none">
                <img src="{{ asset('/images/logo45_sf.png') }}" alt="" style="height: 80px; float:right;">
            </th>
        </tr>
        <tr>
            <th colspan="9" style="border: none;"></th>
        </tr>
        <tr>
            <th colspan="9" style="border: none;"></th>
        </tr>
        <tr>
            <th colspan="9" style="border: none;"></th>
        </tr>
        <tr>
            <th>
                Orden N#
            </th>
            <th>
                Fecha
            </th>
            <th>
                Gasolinera
            </th>
            <th>
                Autorizado por
            </th>
            <th>
                Vehiculo
            </th>
            <th>
                Chofer
            </th>
            <th>
                T. Combustible
            </th>
            <th>
                Cantidad (Litros)
            </th>
            <th>
                Cantidad (Galones)
            </th>
        </tr>

    </thead>

    <tbody>
        @php
            $sumaTotalSolicitadasL = 0;
            $sumaTotalSolicitadasGal = 0;
        @endphp
        @foreach ($relaciones as $orden)
            <tr>
                <td>
                    {{ $orden->orden->id }}
                </td>
                <td>
                    {{ $orden->orden->fecha }}
                </td>
                <td>
                    {{ $orden->orden->gasolinera->nombre }}
                </td>
                <td>
                    {{ $orden->orden->autorizado->primer_nombre }} {{ $orden->orden->autorizado->segundo_nombre }} {{ $orden->orden->autorizado->primer_apellido }} {{ $orden->orden->autorizado->segundo_apellido }}
                </td>
                <td>
                    {{ $orden->detalleOrden->vehiculo->placa }}
                </td>
                <td>
                    {{ $orden->detalleOrden->chofer->primer_nombre }} {{ $orden->detalleOrden->chofer->segundo_nombre }} {{ $orden->detalleOrden->chofer->primer_apellido }} {{ $orden->detalleOrden->chofer->segundo_apellido }}
                </td>
                <td>
                    {{ $orden->detalleOrden->combustible->nombre }}
                </td>
                <td>
                @if ($orden->detalleOrden->medida == 'Litros')
                    {{ $orden->detalleOrden->cantidad }}
                    @php
                        $sumaTotalSolicitadasL += $orden->detalleOrden->cantidad ;
                    @endphp
                @else
                    {{number_format($orden->detalleOrden->cantidad * 3.785,2)}}
                    @php
                        $sumaTotalSolicitadasL += $orden->detalleOrden->cantidad / 3.785;
                    @endphp
                @endif
                </td>
                <td>
                @if ($orden->detalleOrden->medida == 'Galones')
                    {{ $orden->detalleOrden->cantidad }}
                    @php
                        $sumaTotalSolicitadasGal += $orden->detalleOrden->cantidad ;
                    @endphp
                    
                @else
                    {{number_format($orden->detalleOrden->cantidad / 3.785,2)}}
                    @php
                        $sumaTotalSolicitadasGal += $orden->detalleOrden->cantidad / 3.785;
                    @endphp
                @endif
                </td>
            </tr>    
        @endforeach
    <tr>
        <td colspan="7"  style="background-color:lightsteelblue;">
            Total
        </td>
        <td style="background-color:antiquewhite;">
            {{number_format($sumaTotalSolicitadasL,2)}} Litros
        </td>
        <td style="background-color:antiquewhite;">
            {{number_format($sumaTotalSolicitadasGal,2)}} Galones
        </td>
    </tr>
    </tbody>

</table>

<div style=" bottom: 0; width: 100%; display: flex; justify-content: center; align-items: center; border: none;">
    <table style="width: 100%; text-align: center; border: none;">
        <thead>
            <tr>
                <th style="width: 100%; text-align: center; display:flex; justify-content:center; border: none;">
                    <img src="{{ asset('/images/logo_pie.webp') }}" alt="" style="width: 220px;">
                </th>
            </tr>
        </thead>
    </table>    
</div>

</div>

@endsection