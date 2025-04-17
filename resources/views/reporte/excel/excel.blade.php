<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Exportar Tabla a Excel</title>
</head>
<body>
<style>
    /* Estilos para el encabezado y pie de página en cada hoja */
    @media print {
        .page-break { 
            page-break-before: always;
        }
        header, footer {
            position: fixed;
            width: 100px;
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
        font-size: 24px;
        font-weight: bold;
    }
    .text-xl {
        font-size: 20px;
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

<style>
    /* Centrar el contenido de todas las celdas */
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        vertical-align: middle;
    }
    img {
            width: 20px; /* Cambia este valor al tamaño deseado */
            height: 20px; /* Cambia este valor al tamaño deseado */
        }
</style>

<header>


        <table style="border:none;">
            <tr style="border:none;">
                <td style="border:none;">
                <div style="position:absolute; left: 0; top: 0;">
                    <img src="{{ asset('/images/logo.png') }}" alt=""  width="80" height="80" >
                </div>
                </td>
                <td style="border:none;" colspan="5">
                <div style="flex: 1; text-align: center;">
                    <p class="text-2xl">Alcaldía Municipal de Leon</p>
                    <p class="text-xl">Reporte Consolidado</p>
                    <p class="text-lg">{{ $startDate}} - {{ $endDate }}</p>
                </div>
                </td>
                <td style="border:none;">
                <div style=" position:absolute; right: 0; top:0; width:90px; height: 90px;">
                    <img src="{{ asset('/images/logo45_sf.png') }}" alt=""  width="100" height="100" >
                </div>
                </td>
            </tr>
        </table>





</header>



<div class="content">
    <table id="reporteTabla">
        <thead>
            <tr>
                <th>Fecha Solicitada</th>
                <th>Fecha Entregada</th>
                <th># Orden</th>
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
            @endphp
        @foreach ($ordenes as $orden)
            <tr>
                <td>
                    {{ $orden->fecha }} <br>
                </td>
                <th>
                    @php
                        $pendiente = true;
                    @endphp
                    @foreach ($entregadas as $entregada )
                        @if ($entregada->relacionOrdenDetalle->orden_id == $orden->id)
                            {{ $entregada->fecha }}
                            @php
                                $pendiente = false;
                            @endphp
                            @break
                        @else

                        @endif
                    
                    @endforeach
                    @if ($pendiente)
                        Pendiente
                    @endif
                </th>

                <td>
                    {{ $orden->id }}
                </td>
                <td>
                    @php
                        $totalSolicitadoL = 0;
                    @endphp

                    @foreach ($relaciones as $relacion)
                        @if ($relacion->orden_id == $orden->id)
                            @php
                            if($relacion->detalleOrden->medida == 'Litros')
                            {
                                $totalSolicitadoL += $relacion->detalleOrden->cantidad;
                            }
                            else
                            {
                                $totalSolicitadoL += $relacion->detalleOrden->cantidad * 3.785;
                            }
                                
                            @endphp
                        @endif
                    @endforeach
                    {{ number_format($totalSolicitadoL  ,2) }} Litros
                    @php
                        $sumaTotalSolicitadasL += $totalSolicitadoL;
                    @endphp
                </td>
                <td>
                @php
                    $totalSolicitadoGal = 0;
                    @endphp

                    @foreach ($relaciones as $relacion)
                        @if ($relacion->orden_id == $orden->id)
                            @php
                            if($relacion->detalleOrden->medida == 'Galones')
                            {
                                $totalSolicitadoGal += $relacion->detalleOrden->cantidad;
                            }
                            else
                            {
                                $totalSolicitadoGal += $relacion->detalleOrden->cantidad / 3.785;
                            }
                                
                            @endphp
                        @endif
                    @endforeach
                    {{ number_format($totalSolicitadoGal,2) }} Galones
                    @php
                        $sumaTotalSolicitadasGal += $totalSolicitadoGal;
                    @endphp
                </td>
                <td>
                    @php
                        $totalEntregadoL = 0;
                        $totalEntregadoGal = 0;
                    @endphp
                    @foreach ($entregadas as $entregada )

                        @if ($entregada->relacionOrdenDetalle->orden_id == $orden->id && $entregada->entregado == 1)
                            @php
                            if($entregada->relacionOrdenDetalle->detalleOrden->medida == 'Litros')
                            {
                                $totalEntregadoL += $entregada->relacionOrdenDetalle->detalleOrden->cantidad;
                            }
                            else
                            {
                                $totalEntregadoL += $entregada->relacionOrdenDetalle->detalleOrden->cantidad * 3.785;
                            }
                                
                            @endphp
                            
                        @endif
                    
                    @endforeach

                    {{ number_format($totalEntregadoL,2) }} Litros
                    @php
                        $sumaTotalEntregadasL += $totalEntregadoL;
                    @endphp
            
                </td>
                <th>
                @php
                    $totalEntregadoGal = 0;
                    @endphp
                    @foreach ($entregadas as $entregada )

                        @if ($entregada->relacionOrdenDetalle->orden_id == $orden->id && $entregada->entregado == 1)
                            @php
                            if($entregada->relacionOrdenDetalle->detalleOrden->medida == 'Galones')
                            {
                                $totalEntregadoGal += $entregada->relacionOrdenDetalle->detalleOrden->cantidad;
                            }
                            else
                            {
                                $totalEntregadoGal += $entregada->relacionOrdenDetalle->detalleOrden->cantidad / 3.785;
                            }
                                
                            @endphp
                            
                        @endif
                    
                    @endforeach

                    {{ number_format($totalEntregadoGal,2) }} Galones
                    @php
                        $sumaTotalEntregadasGal += $totalEntregadoGal;
                    @endphp
                </th>

            </tr>
        @endforeach
        <tr>
            <td colspan="3">
                <strong>
                    Total
                </strong>
                
            </td>
            <td style="background-color:antiquewhite;">
                {{number_format($sumaTotalSolicitadasL,2)}} Litros
            </td>
            <td style="background-color:antiquewhite;">
                {{number_format($sumaTotalSolicitadasGal,2)}} Galones
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

<div class="page-break"></div> <!-- Forzará un salto de página después del contenido anterior si es necesario -->

</body>
</html>
