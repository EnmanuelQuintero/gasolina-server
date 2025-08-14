<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Órdenes</title>
    <style>
        /** Márgenes de página **/
        @page {
            margin: 160px 25px 80px 25px; /* top | right | bottom | left */
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0; right: 0;
            height: 140px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0; right: 0;
            height: 60px;
            text-align: center;
        }

        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 10px;
        }
        .header-table td {
            border: none;
            vertical-align: middle;
        }
        .header-center h1, .header-center h2, .header-center p {
            margin: 0; padding: 0;
        }
        .header-center h1 { font-size: 18px; }
        .header-center h2 { font-size: 14px; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data th, table.data td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table.data th {
            background-color: #f2f2f2;
        }
        .orden-header {
            background-color: #dfe6e9;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Encabezado fijo -->
    <header>
        <table class="header-table">
            <tr>
                <td width="15%">
                    <img src="{{ public_path('/images/alcaldialeon.png') }}" style="width:50px; height:70px;">
                </td>
                <td class="header-center" style="text-align:center;">
                    <h1>Alcaldía Municipal de León</h1>
                    <h2>Reporte de Órdenes</h2>
                    <p><strong>Desde:</strong> {{ $inicio }} &nbsp;&nbsp; <strong>Hasta:</strong> {{ $fin }}</p>
                </td>
                <td width="15%" style="text-align:right;">
                    <img src="{{ public_path('/images/escudo.png') }}" style="width:70px; height:70px;">
                </td>
            </tr>
        </table>
    </header>

    <!-- Pie de página fijo -->
    <footer>
        <img src="{{ public_path('/images/logo_pie.webp') }}" style="width:220px; height:60px;">
    </footer>

    <!-- Contenido principal -->
    <main>
    @php
        // 1 litro = 0.264172 galones
        define('LITROS_A_GALONES', 0.264172);
        $totalSolicitado = 0;
        $totalEntregado  = 0;
    @endphp

    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Vehículo</th>
                <th>Kilometros</th>
                <th>Chofer</th>
                <th>Combustible</th>
                <th>Cant. Solicitada</th>
                <th>Cant. Entregada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes as $orden)
                {{-- Encabezado de la orden --}}
                <tr class="orden-header">
                    <td colspan="7">
                        Orden #{{ $orden->id }} — Fecha: {{ $orden->fecha }} |
                        Gasolinera: {{ $orden->gasolinera->nombre ?? 'N/D' }} |
                        Autorizada por: {{ $orden->autorizado->primer_nombre ?? '' }} {{ $orden->autorizado->primer_apellido ?? '' }}<br>
                        Observaciones: {{ $orden->observaciones ?? '—' }}
                    </td>
                </tr>

                {{-- Detalles de la orden --}}
                @foreach($orden->relaciones as $idx => $relacion)
                    @php
                        $det = $relacion->detalleOrden;
                        // Litros
                        $litrosSolic = $det->cantidad;
                        $litrosEntreg = $relacion->entregado ? $det->cantidad : 0;
                        // Acumular
                        $totalSolicitado += $litrosSolic;
                        $totalEntregado  += $litrosEntreg;
                        // Galones
                        $galSolic = round($litrosSolic * LITROS_A_GALONES, 2);
                        $galEntreg = round($litrosEntreg  * LITROS_A_GALONES, 2);
                    @endphp
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $det->vehiculo->placa ?? 'N/D' }}</td>
                        <td>{{ $det->kilometros ?? '-' }}</td>

                        <td>{{ $det->chofer->primer_nombre ?? '' }} {{ $det->chofer->primer_apellido ?? '' }}</td>
                        <td>{{ $det->combustible->nombre ?? 'N/D' }}</td>
                        <td>{{ $litrosSolic }} L / {{ $galSolic }} gal</td>
                        <td>
                            @if($relacion->entregado)
                                {{ $litrosEntreg }} L / {{ $galEntreg }} gal
                            @else
                                Pendiente
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            @php
                $totalGalSolic = round($totalSolicitado * LITROS_A_GALONES, 2);
                $totalGalEntreg = round($totalEntregado  * LITROS_A_GALONES, 2);
            @endphp
            <tr>
                <th colspan="4" style="text-align: right;">Totales:</th>
                <th>{{ $totalSolicitado }} L / {{ $totalGalSolic }} gal</th>
                <th>{{ $totalEntregado }} L / {{ $totalGalEntreg }} gal</th>
            </tr>
        </tfoot>
    </table>
    </main>

</body>
</html>
