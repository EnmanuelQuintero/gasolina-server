@extends('layouts.reportes')

@section('content')
<style>
    /* Estilos para el encabezado y pie de página en cada hoja */
    @media print {
        .page-break { 
            page-break-before: always;
        }
        header, footer {
            position: fixed;
            
        }
        header {
            top: 0;
            text-align: center;
            width: 100%;
        }
        footer {
            display:flex;
            justify-content:center;
            width: 100%;
            bottom: 0;
            text-align: center;
        }
        .content {
            margin-top: 130px;
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
    }

    /* Clases personalizadas */


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


<header>
    <div style=" display:flex; text-align:center;">
        <div style="position:absolute; left: 0; top: 0;">
            <img src="{{ asset('/images/logo.png') }}" alt="" style="width:70px; height: 70px;" >
        </div>
        <div style="flex: 1; text-align: center;">
            <label class="text-2xl">Alcaldía Municipal de Leon</label> <br>
            <label class="text-xl">Reporte Consolidado</label>
            <p class="text-lg">{{ $startDate}} - {{ $endDate }}</p>
        </div>
        <div style=" position:absolute; right: 0; top:0; width:90px; height: 90px;">
            <img src="{{ asset('/images/logo45_sf.png') }}" alt="" style="width:80px; height: 80px;" >
        </div>
    </div>
</header>

<footer>
    <div class="absolute bottom-0 full-width" >
        <img src="{{ asset('/images/logo_pie.webp') }}" alt="" class="w-60 h-20" style="margin-top:25px;">
    </div>
    <div class="text-right mr-10">
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script(function($pdf) {
                    $font = $pdf->getFontMetrics()->getFont("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(270, 800, "Página {$pdf->get_page_number()} de {$pdf->get_page_count()}", $font, 12);
                });
            }
        </script>
    </div>
</footer>

<div class="content">
<table>
    <thead>
        <tr>
            <th>Fecha Solicitada</th>
            <th>Fecha Entregada</th>
            <th># Orden</th>
            <th>Gasolinera</th>
            <th>Total Emitido (Litros)</th>
            <th>Total Emitido (Galones)</th>
            <th>Total Entregado (Litros)</th>
            <th>Total Entregado (Galones)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sumaTotalSolicitadasL = 0;
            $sumaTotalSolicitadasGal = 0;
            $sumaTotalEntregadasL = 0;
            $sumaTotalEntregadasGal = 0;
            $procesadas = [];
        @endphp
        @foreach ($relaciones as $orden)
            @if (!in_array($orden->orden->id, $procesadas))
                @php
                    $procesadas[] = $orden->orden->id;
                @endphp
                <tr>
                    <td>{{ $orden->orden->fecha }}</td>
                    <td>
                        @php $pendiente = true; @endphp
                        @foreach ($entregadas as $entregada)
                            @if ($entregada->relacionOrdenDetalle->orden->id == $orden->orden->id)
                                {{ $entregada->fecha }}
                                @php $pendiente = false; @endphp
                                @break
                            @endif
                        @endforeach
                        @if ($pendiente) Pendiente @endif
                    </td>
                    <td>{{ $orden->orden->id }}</td>
                    <td>{{ $orden->orden->gasolinera->nombre }}</td>
                    <td>
                        @php $totalSolicitadoL = 0; @endphp
                        @foreach ($relaciones as $relacion)
                            @if ($relacion->orden_id == $orden->orden->id)
                                @php
                                    $cantidad = $relacion->detalleOrden->cantidad;
                                    $totalSolicitadoL += ($relacion->detalleOrden->medida == 'Litros') ? $cantidad : $cantidad * 3.785;
                                @endphp
                            @endif
                        @endforeach
                        {{ number_format($totalSolicitadoL, 2) }} Litros
                        @php $sumaTotalSolicitadasL += $totalSolicitadoL; @endphp
                    </td>
                    <td>
                        @php $totalSolicitadoGal = 0; @endphp
                        @foreach ($relaciones as $relacion)
                            @if ($relacion->orden_id == $orden->orden->id)
                                @php
                                    $cantidad = $relacion->detalleOrden->cantidad;
                                    $totalSolicitadoGal += ($relacion->detalleOrden->medida == 'Galones') ? $cantidad : $cantidad / 3.785;
                                @endphp
                            @endif
                        @endforeach
                        {{ number_format($totalSolicitadoGal, 2) }} Galones
                        @php $sumaTotalSolicitadasGal += $totalSolicitadoGal; @endphp
                    </td>
                    <td>
                        @php $totalEntregadoL = 0; @endphp
                        @foreach ($entregadas as $entregada)
                            @if ($entregada->relacionOrdenDetalle->orden_id == $orden->id && $entregada->entregado == 1)
                                @php
                                    $cantidad = $entregada->relacionOrdenDetalle->detalleOrden->cantidad;
                                    $totalEntregadoL += ($entregada->relacionOrdenDetalle->detalleOrden->medida == 'Litros') ? $cantidad : $cantidad * 3.785;
                                @endphp
                            @endif
                        @endforeach
                        @if ($totalEntregadoL == 0)
                            Pendiente
                        @else
                            {{ number_format($totalEntregadoL, 2) }} Litros
                        @endif
                        @php $sumaTotalEntregadasL += $totalEntregadoL; @endphp
                    </td>
                    <td>
                        @php $totalEntregadoGal = 0; @endphp
                        @foreach ($entregadas as $entregada)
                            @if ($entregada->relacionOrdenDetalle->orden_id == $orden->id && $entregada->entregado == 1)
                                @php
                                    $cantidad = $entregada->relacionOrdenDetalle->detalleOrden->cantidad;
                                    $totalEntregadoGal += ($entregada->relacionOrdenDetalle->detalleOrden->medida == 'Galones') ? $cantidad : $cantidad / 3.785;
                                @endphp
                            @endif
                        @endforeach
                        @if ($totalEntregadoGal == 0)
                            Pendiente
                        @else
                            {{ number_format($totalEntregadoGal, 2) }} Galones
                        @endif
                        @php $sumaTotalEntregadasGal += $totalEntregadoGal; @endphp
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="4" style="background-color:lightsteelblue;"><strong>Total</strong></td>
            <td style="background-color:antiquewhite;">{{ number_format($sumaTotalSolicitadasL, 2) }} Litros</td>
            <td style="background-color:antiquewhite;">{{ number_format($sumaTotalSolicitadasGal, 2) }} Galones</td>
            <td style="background-color:antiquewhite;">{{ number_format($sumaTotalEntregadasL, 2) }} Litros</td>
            <td style="background-color:antiquewhite;">{{ number_format($sumaTotalEntregadasGal, 2) }} Galones</td>
        </tr>
    </tbody>
</table>

</div>

<div class="page-break"></div> <!-- Forzará un salto de página después del contenido anterior si es necesario -->


@endsection