@extends('layouts.reportes')

@section('content')
<style>
    @media print {
        /* Estilos para el encabezado y pie de página en cada hoja */
        header, footer {
            position: fixed;
            width: 100%;
            text-align: center;
        }
        header {
            top: 0;
        }
        footer {
        bottom: 0;
        text-align: center;
        width: 100%;
        display: flex;
        justify-content: center;
    }
        .content {
            margin-top: 130px; /* Espacio para header */
            margin-bottom: 100px; /* Espacio para footer */
            margin-left: 30px;
            margin-right: 30px;
        }
        .page-break { 
            page-break-before: always;
        }
    }

    /* Clases personalizadas */
    .w-20 { width: 80px; }
    .h-20 { height: 50px; }
    .text-2xl { font-size: 28px; font-weight: bold; }
    .text-xl { font-size: 24px; }
    .text-lg { font-size: 16px; }
</style>

<header>
    <div style="display: flex; align-items: center; justify-content: center; position: relative;">
        <div style="position: absolute; left: 0;">
            <img src="{{ public_path('/images/logo.png') }}" alt="" style="width: 70px; height: 70px;">
        </div>
        <div style="text-align: center;">
            <h1 class="text-2xl">Alcaldía Municipal de León</h1>
            <h2 class="text-xl">Reporte Consolidado</h2>
            <p class="text-lg">{{ $startDate }} - {{ $endDate }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 0;">
            <img src="{{ public_path('/images/logo45_sf.png') }}" alt="" style="width: 80px; height: 80px;">
        </div>
    </div>
</header>


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
                @php $procesadas[] = $orden->orden->id; @endphp
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
                        {{ number_format($totalSolicitadoL = $relaciones->where('orden_id', $orden->orden->id)->sum(function($relacion) { 
                            return $relacion->detalleOrden->medida == 'Litros' ? $relacion->detalleOrden->cantidad : $relacion->detalleOrden->cantidad * 3.785; 
                        }), 2) }} Litros
                    </td>
                    <td>
                        {{ number_format($totalSolicitadoGal = $relaciones->where('orden_id', $orden->orden->id)->sum(function($relacion) { 
                            return $relacion->detalleOrden->medida == 'Galones' ? $relacion->detalleOrden->cantidad : $relacion->detalleOrden->cantidad / 3.785; 
                        }), 2) }} Galones
                    </td>
                    <td>
                        {{ $totalEntregadoL = $entregadas->where('relacionOrdenDetalle.orden_id', $orden->orden->id)->sum(function($entregada) { 
                            return $entregada->relacionOrdenDetalle->detalleOrden->medida == 'Litros' ? $entregada->relacionOrdenDetalle->detalleOrden->cantidad : $entregada->relacionOrdenDetalle->detalleOrden->cantidad * 3.785; 
                        }) ?: 'Pendiente' }} Litros
                    </td>
                    <td>
                        {{ $totalEntregadoGal = $entregadas->where('relacionOrdenDetalle.orden_id', $orden->orden->id)->sum(function($entregada) { 
                            return $entregada->relacionOrdenDetalle->detalleOrden->medida == 'Galones' ? $entregada->relacionOrdenDetalle->detalleOrden->cantidad : $entregada->relacionOrdenDetalle->detalleOrden->cantidad / 3.785; 
                        }) ?: 'Pendiente' }} Galones
                    </td>
                </tr>
                @php
                    $sumaTotalSolicitadasL += is_numeric($totalSolicitadoL) ? $totalSolicitadoL : 0;
                    $sumaTotalSolicitadasGal += is_numeric($totalSolicitadoGal) ? $totalSolicitadoGal : 0;
                    $sumaTotalEntregadasL += is_numeric($totalEntregadoL) ? $totalEntregadoL : 0;
                    $sumaTotalEntregadasGal += is_numeric($totalEntregadoGal) ? $totalEntregadoGal : 0;
                @endphp

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
<footer style="position: fixed; bottom: 0; left: 0; right: 0; height: 40px;">
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0 10px;">
        <div>
            <img src="{{ public_path('/images/logo_pie.webp') }}" alt="" style="width: 240px; height: 50px; margin-left:370px;">
        </div>
        <div>
            <script type="text/php">
                if (isset($pdf)) {
                    $pdf->page_script(function($pdf) {
                        $pdf->text(270, 800, "Página {$pdf->get_page_number()} de {$pdf->get_page_count()}", 'Helvetica', 10);
                    });
                }
            </script>
        </div>
    </div>
</footer>

<div class="page-break"></div>
@endsection
