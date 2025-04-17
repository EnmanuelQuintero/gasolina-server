@extends('layouts.reportes')

@section('content')
<style>
    /* Estilos para el encabezado y pie de página en cada hoja */
    @media print {
        .page-break { 
            page-break-before: always;
        }
        header {
            top: 0;
            text-align: center;
            width: 100%;
        }
        footer {
            bottom: 0;
            text-align: center;
        }
        .content {
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 100px;
        }
        footer .pageNumber::after {
            content: counter(page);
        }
        footer .totalPages::after {
            content: counter(pages);
        }
        
        header,footer{
            position: fixed;
        }
        /* Clases personalizadas */
    }

    .w-20 {
        width: 80px;
    }
    .h-20 {
        height: 50px;
    }
    .text-2xl {
        font-size: 28px;
        font-weight: bold;
    }
    .text-xl {
        font-size: 24px;
    }

    .text-lg {
        font-size: 16px;
    }
    .absolute {
        position: absolute;
    }
    .bottom-0 {
        bottom: 0;
    }
    .w-60 {
        width: 240px;
    }
    .mr-10 {
        margin-right: 10px;
    }
</style>

<div class="content">
    <table style="border:none;">
        <thead>
            <tr style="border:none; background-color:white;">
                <th style="border:none;">
                    <div style="position:absolute; left: 0; top: 0;">
                        <img src="{{ asset('/images/logo.png') }}" alt="" style="width:70px; height: 70px;" >
                    </div>
                </th>
                <th colspan="6" style="border:none;">
                    <div style="flex: 1; text-align: center;">
                        <p class="text-2xl">Alcaldía Municipal de Leon</p>
                        <label class="text-xl">Reporte Ordenes Entregadas</label>
                        <p class="text-lg">{{ $startDate }} - {{ $endDate }}</p>
                    </div>

                </th>
                <th style="border:none;">
                    <div style=" position:absolute; right: 0; top:0; width:90px; height: 90px;">
                        <img src="{{ asset('/images/logo45_sf.png') }}" alt="" style="width:80px; height: 80px;" >
                    </div>
                </th>
            </tr>
            <tr>
                <th>Fecha Solicitada</th>
                <th># Orden</th>
                <th>Gasolinera</th>
                <th>Placa Vehiculo</th>
                <th>Chofer</th>
                <th>Combustible</th>
                <th>Detalle Entregado (Litros)</th>
                <th>Detale Entregado (Galones)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumaTotalEntregadasL = 0;
                $sumaTotalEntregadasGal = 0;
            @endphp
        @foreach ($entregadas as $orden)
            @if ($orden->entregado== 1)
                <tr>
                    <td>
                        {{ $orden->relacionOrdenDetalle->orden->fecha }} <br>
                    </td>

                    <td>
                        {{ $orden->relacionOrdenDetalle->orden->id }}
                    </td>
                    <th>

                        {{ $orden->relacionOrdenDetalle->orden->gasolinera->nombre }}
                    </th>
                    <td>
                        {{ $orden->relacionOrdenDetalle->detalleOrden->vehiculo->placa }}
                    </td>
                    <td>
                        {{ $orden->relacionOrdenDetalle->detalleOrden->chofer->primer_nombre }} {{ $orden->relacionOrdenDetalle->detalleOrden->chofer->segundo_nombre }} {{ $orden->relacionOrdenDetalle->detalleOrden->chofer->primer_apellido }} {{ $orden->relacionOrdenDetalle->detalleOrden->chofer->segundo_apellido }}
                    </td>
                    <td>
                        {{ $orden->relacionOrdenDetalle->detalleOrden->combustible->nombre }}
                    </td>
                    <td>
                        @if ($orden->relacionOrdenDetalle->detalleOrden->medida == 'Litros')
                            {{$orden->relacionOrdenDetalle->detalleOrden->cantidad}} Litros
                            @php
                                $sumaTotalEntregadasL += $orden->relacionOrdenDetalle->detalleOrden->cantidad;
                            @endphp
                        @else
                            {{number_format($orden->relacionOrdenDetalle->detalleOrden->cantidad * 3.785,2)}}
                            @php
                                $sumaTotalEntregadasL += $orden->relacionOrdenDetalle->detalleOrden->cantidad * 3.785;
                            @endphp
                        @endif
                    </td>
                    <td>
                        @if ($orden->relacionOrdenDetalle->detalleOrden->medida == 'Galones')
                            {{$orden->relacionOrdenDetalle->detalleOrden->cantidad}} Galones
                            @php
                                $sumaTotalEntregadasGal += $orden->relacionOrdenDetalle->detalleOrden->cantidad;
                            @endphp
                        @else
                            {{number_format($orden->relacionOrdenDetalle->detalleOrden->cantidad / 3.785,2)}}
                            @php
                                $sumaTotalEntregadasGal += $orden->relacionOrdenDetalle->detalleOrden->cantidad / 3.785;
                            @endphp
                        @endif
                        
                    </td>

                </tr>
            @endif
            
        @endforeach
        <tr>
            <td colspan="6"  style="background-color:lightsteelblue;">
                <strong>
                    Total
                </strong>
                
            </td>
            <td style="background-color:antiquewhite;">
                {{number_format($sumaTotalEntregadasL,2)}} Litros
            </td>
            <td style="background-color:antiquewhite;">
                {{number_format($sumaTotalEntregadasGal,2)}} Galones
            </td>
        </tr>

        </tbody>
    </table>
</div>

<div class="absolute bottom-0 full-width" style=" margin-left:38%; ">
    <table style="border:none; background-color: white;">
        <thead style="border:none; background-color: white;">
            <th style="border:none; background-color: white;">
                <img src="{{ asset('/images/logo_pie.webp') }}" alt="" class="w-60 h-20" style="margin-top:25px;">
            </th>
        </thead>
    </table>
    
</div>
<div class="page-break"></div> <!-- Forzará un salto de página después del contenido anterior si es necesario -->


@endsection