<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Avanzado</title>
    <style>
        @page {
            margin: 160px 25px 80px 25px;
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
        }

        .header-center h1, .header-center h2, .header-center p {
            margin: 0; padding: 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.data th, table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data th {
            background-color: #f2f2f2;
        }

        .grupo-header {
            background-color: #dfe6e9;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('/images/alcaldialeon.png') }}" style="width:50px; height:70px;">
            </td>
            <td class="header-center" style="text-align:center;">
                <h1>Alcaldía Municipal de León</h1>
                <h2>Reporte Avanzado por {{ ucfirst($filtro) }}</h2>
                <p><strong>Desde:</strong> {{ $fecha_inicio }} &nbsp;&nbsp; <strong>Hasta:</strong> {{ $fecha_fin }}</p>
            </td>
            <td width="15%" style="text-align:right;">
                <img src="{{ public_path('/images/escudo.png') }}" style="width:70px; height:70px;">
            </td>
        </tr>
    </table>
</header>

<footer>
    <img src="{{ public_path('/images/logo_pie.webp') }}" style="width:220px; height:60px;">
</footer>

<main>
    @foreach($agrupadas as $grupo => $items)
        <table class="data">
            @if($filtro === 'vehiculo')
                @foreach($items as $rel)
                    <thead>
                        <tr class="grupo-header">
                            <td colspan="6">
                                Orden #{{ $rel->orden->id }} - {{ $rel->orden->fecha }} - 
                                {{ $rel->orden->gasolinera->nombre ?? 'N/D' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Vehículo</th>
                            <th>Kilometros</th>
                            <th>Chofer</th>
                            <th>Combustible</th>
                            <th>Cant. Solicitada (L / gal)</th>
                            <th>Cant. Entregada (L / gal)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $rel->detalleOrden->vehiculo->placa }}</td>
                            <td>{{ $rel->detalleOrden->kilometros ?? '-' }}</td>
                            <td>{{ $rel->detalleOrden->chofer->primer_nombre }} {{ $rel->detalleOrden->chofer->primer_apellido }}</td>
                            <td>{{ $rel->detalleOrden->combustible->nombre }}</td>
                            <td>
                                {{ number_format($rel->detalleOrden->cantidad, 2) }} L /
                                {{ number_format($rel->detalleOrden->cantidad / 3.78541, 2) }} gal
                            </td>
                            <td>
                                @if($rel->entregado)
                                    {{ number_format($rel->detalleOrden->cantidad, 2) }} L /
                                    {{ number_format($rel->detalleOrden->cantidad / 3.78541, 2) }} gal
                                @else
                                    0.00 L / 0.00 gal
                                @endif
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            @else
                @foreach($items as $orden)
                    <thead>
                        <tr class="grupo-header">
                            <td colspan="6">
                                Orden #{{ $orden->id }} - {{ $orden->fecha }} - 
                                {{ $orden->gasolinera->nombre ?? 'N/D' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Vehículo</th>
                            <th>Kilometros</th>
                            <th>Chofer</th>
                            <th>Combustible</th>
                            <th>Cant. Solicitada (L / gal)</th>
                            <th>Cant. Entregada (L / gal)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->relaciones as $rel)
                            <tr>
                                <td>{{ $rel->detalleOrden->vehiculo->placa }}</td>
                                <td>{{ $rel->detalleOrden->kilometros ?? '-' }}</td>
                                <td>{{ $rel->detalleOrden->chofer->primer_nombre }} {{ $rel->detalleOrden->chofer->primer_apellido }}</td>
                                <td>{{ $rel->detalleOrden->combustible->nombre }}</td>
                                <td>
                                    {{ number_format($rel->detalleOrden->cantidad, 2) }} L /
                                    {{ number_format($rel->detalleOrden->cantidad / 3.78541, 2) }} gal
                                </td>
                                <td>
                                    @if($rel->entregado)
                                        {{ number_format($rel->detalleOrden->cantidad, 2) }} L /
                                        {{ number_format($rel->detalleOrden->cantidad / 3.78541, 2) }} gal
                                    @else
                                        0.00 L / 0.00 gal
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endforeach
            @endif
        </table>
    @endforeach
</main>


</body>
</html>
