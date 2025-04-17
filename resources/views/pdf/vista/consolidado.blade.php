<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $reporte }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            height: 70px;
        }

        .titulo {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .subtitulo {
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f0f0f0;
        }

        th, td {
            padding: 6px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="data:image/jpeg;base64,{{ $image }}" alt="Logo">
    <div class="titulo">{{ $reporte }}</div>
    <div class="subtitulo">Fecha de emisión: {{ $fecha }}</div>
</div>

<h3>Resumen General</h3>
<table>
    <thead>
        <tr>
            <th>Total Órdenes</th>
            <th>Solicitado (L)</th>
            <th>Solicitado (Gal)</th>
            <th>Entregado (L)</th>
            <th>Entregado (Gal)</th>
            <th>% Entregado</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $resumenGeneral['total_ordenes'] }}</td>
            <td>{{ number_format($resumenGeneral['litros_solicitado'], 2) }}</td>
            <td>{{ number_format($resumenGeneral['galones_solicitado'], 2) }}</td>
            <td>{{ number_format($resumenGeneral['litros_entregado'], 2) }}</td>
            <td>{{ number_format($resumenGeneral['galones_entregado'], 2) }}</td>
            <td>{{ $resumenGeneral['porcentaje_entregado'] }}%</td>
        </tr>
    </tbody>
</table>



<h3>Resumen Consolidado por Día</h3>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Total de Órdenes</th>
            <th>Solicitado (L / gal)</th>
            <th>Entregado (L / gal)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordenes as $orden)
            @php
                $total_solicitado = $orden['total_solicitado'];
                $total_entregado = $orden['total_entregado'];
                $medida = strtolower($orden['medida'] ?? 'litros');

                $litros_solicitado = 0;
                $galones_solicitado = 0;
                $litros_entregado = 0;
                $galones_entregado = 0;

                if ($medida === 'galones') {
                    $litros_solicitado = $total_solicitado * 3.78541;
                    $galones_solicitado = $total_solicitado;

                    $litros_entregado = $total_entregado * 3.78541;
                    $galones_entregado = $total_entregado;
                }

                if ($medida === 'litros') {
                    $litros_solicitado = $total_solicitado;
                    $galones_solicitado = $total_solicitado / 3.78541;

                    $litros_entregado = $total_entregado;
                    $galones_entregado = $total_entregado / 3.78541;
                }
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($orden['fecha'])->format('d-m-Y') }}</td>
                <td>{{ $orden['total_ordenes'] }}</td>
                <td>{{ number_format($litros_solicitado, 2) }} L / {{ number_format($galones_solicitado, 2) }} gal</td>
                <td>{{ number_format($litros_entregado, 2) }} L / {{ number_format($galones_entregado, 2) }} gal</td>
            </tr>
        @endforeach
    </tbody>
</table>



<h3>Detalle de Órdenes Entregadas</h3>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Autorizado</th>
            
            <th>Gasolinera</th>
            <th>Tipo de Combustible</th>
            <th>Vehículo</th>
            <th>Chofer</th>
            <th>Departamento - Cargo</th>

            <th>Cantidad Entregada</th>
        </tr>
    </thead>
    <tbody>
        @foreach($relacionesFiltradas as $relacion)
            @php
                $cantidad = $relacion->detalleOrden->cantidad;
                $medida = strtolower($relacion->detalleOrden->medida); // Asegura comparación insensible a mayúsculas
                $litros = 0;
                $galones = 0;

                if ($medida === 'galones') {
                    $litros = $cantidad * 3.78541;
                    $galones = $cantidad;
                } elseif ($medida === 'litros') {
                    $litros = $cantidad;
                    $galones = $cantidad / 3.78541;
                }
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($relacion->orden->fecha)->format('d-m-Y') }}</td>
                <td>{{ $relacion->orden->autorizado->primer_nombre ?? 'N/A' }} {{ $relacion->orden->autorizado->primer_apellido ?? 'N/A' }}</td>
                <td>{{ $relacion->orden->gasolinera->nombre }}</td>
                <td>{{ $relacion->detalleOrden->combustible->nombre }}</td>
                <td>{{ $relacion->detalleOrden->vehiculo->placa ?? 'N/A' }}</td>
                <td>{{ $relacion->detalleOrden->chofer->primer_nombre ?? 'N/A' }} {{ $relacion->detalleOrden->chofer->primer_apellido ?? 'N/A' }}</td>
                <td>{{ $relacion->detalleOrden->chofer->departamentoCargo->departamento->nombre ?? 'N/A' }} - {{ $relacion->detalleOrden->chofer->departamentoCargo->cargo->nombre ?? 'N/A' }}</td>

                <td>
                    {{ number_format($litros, 2) }} L /
                    {{ number_format($galones, 2) }} gal
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Detalle de Órdenes No Entregadas</h3>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Autorizado</th>
            
            <th>Gasolinera</th>
            <th>Tipo de Combustible</th>
            <th>Vehículo</th>
            <th>Chofer</th>
            <th>Departamento - Cargo</th>
            <th>Cantidad No Entregada</th>
        </tr>
    </thead>
    <tbody>
        @foreach($relacionesNoEntregadas as $relacion)
            @php
                $cantidad = $relacion->detalleOrden->cantidad;
                $medida = strtolower($relacion->detalleOrden->medida); // Asegura comparación insensible a mayúsculas
                $litros = 0;
                $galones = 0;

                if ($medida === 'galones') {
                    $litros = $cantidad * 3.78541;
                    $galones = $cantidad;
                } elseif ($medida === 'litros') {
                    $litros = $cantidad;
                    $galones = $cantidad / 3.78541;
                }
            @endphp
        <tr>
                <td>{{ \Carbon\Carbon::parse($relacion->orden->fecha)->format('d-m-Y') }}</td>
                <td>{{ $relacion->orden->autorizado->primer_nombre ?? 'N/A' }} {{ $relacion->orden->autorizado->primer_apellido ?? 'N/A' }}</td>
                <td>{{ $relacion->orden->gasolinera->nombre }}</td>
                <td>{{ $relacion->detalleOrden->combustible->nombre }}</td>
                <td>{{ $relacion->detalleOrden->vehiculo->placa ?? 'N/A' }}</td>
                <td>{{ $relacion->detalleOrden->chofer->primer_nombre ?? 'N/A' }} {{ $relacion->detalleOrden->chofer->primer_apellido ?? 'N/A' }}</td>
                <td>{{ $relacion->detalleOrden->chofer->departamentoCargo->departamento->nombre ?? 'N/A' }} - {{ $relacion->detalleOrden->chofer->departamentoCargo->cargo->nombre ?? 'N/A' }}</td>
                <td>
                    {{ number_format($litros, 2) }} L /
                    {{ number_format($galones, 2) }} gal
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="footer">
    <img src="data:image/png;base64,{{ $image45 }}" alt="Logo 45" style="height: 40px;">
</div>

</body>
</html>
