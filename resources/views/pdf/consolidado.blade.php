<!DOCTYPE html>
<html>
<head>
    <title>Consolidado</title>
    <style>
        @page {

            margin: 160px 50px; /* Ajusta el margen para espacio de cabecera y pie de página */
        }
        .header {
            position: fixed;
            top: -160px;
            left: 0;
            right: 0;
            text-align: center;
            height: 80px; /* Ajusta la altura del encabezado */
            padding: 10px 0;
            z-index: 1;
            width: 100%;
        }
        .header img {
            height: 60px; /* Ajusta el tamaño de las imágenes */
        }
        .header h1 {
            font-size: 20px; /* Ajusta el tamaño del título */
            margin: 0;
            width: 100%;
        }
        .header p {
            font-size: 14px; /* Ajusta el tamaño del texto */
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        footer {
            position: fixed;
            left: 0px;
            bottom: -150px;
            right: 0px;
            height: 40px;
            border: none;

        }
        footer table {
            width: 100%;
            border: none;
        }
        footer p {
            text-align: right;
            border: none;
        }
        footer .izq {
            text-align: left;
            border: none;
        }

        footer .centro{
            text-align: center;
            margin-left: 110px;
        }
        footer .page:before {
            content: counter(page);
        }
    </style>
</head>
<body>



<div class="header">
    <table style="width: 100%; border:none;">
        <tr>
            <td style="width: 30.33%; text-align: left; border:none;">
                <img src="data:image/jpeg;base64,{{ $image }}" alt="" style="width: 60px; padding: 5px;">
            </td>
            <td style="width: 36.33%; text-align: center; border:none;">
                <h1>Alcaldía Municipal de León</h1>
                <p>{{$reporte}}</p>
            </td>
            <td style="width: 30.33%; text-align: right; border:none;">
                <img src="data:image/jpeg;base64,{{ $image45 }}" alt="" style="width: 60px; padding: 5px;">
            </td>
        </tr>
    </table>
</div>
    <footer>
    <table style="border:none;">
        <tr style="border:none;">
            <td style="border:none;">

                
            </td>
            <td style="border:none; " >

                <p class="centro">
                   Fecha de Impresion: {{$fecha}}
                </p>
    
            </td>
            <td style="border:none;">
                <p class="page">
                    Página
                </p>
            </td>
        </tr>
    </table>
  </footer>
    <table>
        <thead>
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
            @foreach ($ordenes as $orden )

            @if ($orden->entregada === 1 && $orden->activo == 1 && $orden->fecha_entregada > $startDate && $orden->fecha_entregada < $endDate )
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
                        {{number_format($suma,2)}} L
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
                        {{number_format($suma,2)}} gal
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
                        {{number_format($suma,2)}} L
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
                        {{number_format($suma,2)}} gal
                        @php
                            $medida=$detalle->medida;
                            $totalDescargadoGal+=$suma;
                            $suma=0;
                        @endphp
                    </td>
                </tr>
            @endif
            @endforeach
            <tr class="bg-gray-100" style="border:2px solid black;">
                <td style="border:none;" colspan="6"><strong>Totales</strong></td>


                <td style="border:none;">{{ number_format($totalSolicitadoL,2) . ' ' . 'L' }}</td>
                <td style="border:none;">{{ number_format($totalSolicitadoGal,2) . ' ' . 'gal' }}</td>
                <td style="border:none;">{{ number_format($totalDescargadoL ,2). ' ' . 'L' }}</td>
                <td style="border:none;">{{ number_format($totalDescargadoGal,2) . ' ' . 'gal' }}</td>
            </tr>
        </tbody>

    </table>
</body>
</html>
