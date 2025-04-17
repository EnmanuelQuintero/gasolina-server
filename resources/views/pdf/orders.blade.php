<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 160px 50px; /* Ajusta el margen para espacio de cabecera y pie de página */
        }
        body {
            font-family: sans-serif;
            font-size: 10px;
            line-height: 1.2;
            padding: 0;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            page-break-inside: auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
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
        }
        .header img {
            height: 60px; /* Ajusta el tamaño de las imágenes */
        }
        .header h1 {
            font-size: 20px; /* Ajusta el tamaño del título */
            margin: 0;
        }
        .header p {
            font-size: 16px; /* Ajusta el tamaño del texto */
            margin: 0;
        }
        main {

            margin-bottom: 10px; /* Ajusta según el margen superior del pie de página */
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
                <td style="width: 33.33%; text-align: left; border:none;">
                    <img src="data:image/jpeg;base64,{{ $image }}" alt="" style="width: 60px; padding: 5px;">
                </td>
                <td style="width: 33.33%; text-align: center; border:none;">
                    <h1>Alcaldía Municipal de León</h1>
                    <p>{{ $reporte }}</p>
                </td>
                <td style="width: 33.33%; text-align: right; border:none;">
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
    <main>
        @if ($orders->isEmpty())
            <p>No hay datos para mostrar.</p>
        @else
            <table>
                <thead>
                    <tr >
                        <th >Orden # </th>
                        <th>Fecha de creacion</th>
                        <th>Fecha de Entrega</th>
                        <th>Gasolinera</th>
                        <th>Autorizado por</th>
                        <th>Área Autorizado</th>
                        <th>Cargo Autorizado</th>
                        <th>Número de Placa</th>
                        <th>Tipo Vehículo</th>
                        <th>Marca Vehículo</th>
                        <th>Modelo Vehículo</th>
                        <th>Color Vehículo</th>
                        <th>Chofer</th>
                        <th>Cargo Chofer</th>
                        <th>Combustible</th>
                        <th>Cantidad (Litros)</th>
                        <th>Cantidad (Galones)</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @foreach ($order->detalles as $detalle)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->fecha }}</td>
                                @if ($order->fecha_entregada != null)
                                    <td>{{ $order->fecha_entregada }}</td>
                                @else
                                    <td>Sin entregar</td>
                                @endif
                                <td>{{ $order->gasolinera->nombre ?? 'N/A' }}</td>
                                <td>{{ $order->autorizado->primer_nombre . ' ' . $order->autorizado->primer_apellido ?? 'N/A' }}</td>
                                <td>{{ $order->autorizado->area->nombre ?? 'N/A' }}</td>
                                <td>{{ $order->autorizado->cargo->nombre ?? 'N/A' }}</td>
                                <td>{{ $detalle->vehiculo->placa ?? 'N/A' }}</td>
                                <td>{{ $detalle->vehiculo->tipo ?? 'N/A' }}</td>
                                <td>{{ $detalle->vehiculo->marca->nombre ?? 'N/A' }}</td>
                                <td>{{ $detalle->vehiculo->modelo->nombre ?? 'N/A' }}</td>
                                <td>{{ $detalle->vehiculo->color ?? 'N/A' }}</td>
                                <td>{{ $detalle->chofer->primer_nombre . ' ' . $detalle->chofer->primer_apellido ?? 'N/A' }}</td>
                                <td>{{ $detalle->chofer->cargo->nombre ?? 'N/A' }}</td>
                                <td>{{ $detalle->combustible->nombre ?? 'N/A' }}</td>
                                <td>
                                    @if ($detalle->medida == 'Litros')
                                        {{ $detalle->cantidad }} L
                                    @else
                                        {{ number_format($detalle->cantidad * 3.785,2) }} L
                                    @endif
                                    
                                </td>
                                <td>
                                    @if ($detalle->medida == 'Galones')
                                        {{ $detalle->cantidad }} gal
                                    @else
                                        {{ number_format($detalle->cantidad / 3.785,2) }} gal
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>


</body>
</html>
