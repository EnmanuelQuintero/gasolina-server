@extends('layouts.reportes')

@section('content')
<style>
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
            display: flex;
            justify-content: center;
            width: 100%;
            bottom: 0;
            text-align: center;
        }
        .content {
            margin-top: 50px;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 50px;
        }
        table {
            width: 100%;
            table-layout: fixed;  /* Asegúrate de que la tabla no se estire demasiado */
        }

        tr {
            page-break-inside: avoid;  /* Previene saltos de página dentro de las filas */
        }


        footer .pageNumber::after {
            content: counter(page);
        }
        footer .totalPages::after {
            content: counter(pages);
        }
    }
</style>

<header>
    <div style="display: flex; text-align: center;">
        <div style="position: absolute; left: 0; top: 0;">
            <img src="{{ asset('/images/logo.png') }}" alt="" style="width:70px; height: 70px;">
        </div>
        <div style="flex: 1; text-align: center;">
            <label class="text-2xl">Alcaldía Municipal de Leon</label><br>
            <label class="text-xl">Reporte Ordenes Solicitadas</label>
            <p class="text-lg">{{ $startDate }} - {{ $endDate }}</p>
        </div>
        <div style="position: absolute; right: 0; top: 0; width:90px; height: 90px;">
            <img src="{{ asset('/images/logo45_sf.png') }}" alt="" style="width:80px; height: 80px;">
        </div>
    </div>
</header>

<footer>
    <div class="absolute bottom-0 full-width">
        <img src="{{ asset('/images/logo_pie.webp') }}" alt="" class="w-60 h-16" style="margin-top:25px;">
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

<div class="content" style="margin-bottom:500px;">
    <table class="primera" style="border: none; margin-bottom: 120px;">
        <thead>
            <tr>
                <th>Orden N°</th>
                <th>Fecha</th>
                <th>Gasolinera</th>
                <th>Autorizado por</th>
                <th>Vehiculo</th>
                <th>Chofer</th>
                <th>T. Combustible</th>
                <th>Cantidad (Litros)</th>
                <th>Cantidad (Galones)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumaTotalSolicitadasL = 0;
                $sumaTotalSolicitadasGal = 0;
            @endphp
            @foreach ($relaciones as $orden)
                <tr>
                    <td>{{ $orden->orden->id }}</td>
                    <td>{{ $orden->orden->fecha }}</td>
                    <td>{{ $orden->orden->gasolinera->nombre }}</td>
                    <td>{{ $orden->orden->autorizado->primer_nombre }} {{ $orden->orden->autorizado->segundo_nombre }} {{ $orden->orden->autorizado->primer_apellido }} {{ $orden->orden->autorizado->segundo_apellido }}</td>
                    <td>{{ $orden->detalleOrden->vehiculo->placa }}</td>
                    <td>{{ $orden->detalleOrden->chofer->primer_nombre }} {{ $orden->detalleOrden->chofer->segundo_nombre }} {{ $orden->detalleOrden->chofer->primer_apellido }} {{ $orden->detalleOrden->chofer->segundo_apellido }}</td>
                    <td>{{ $orden->detalleOrden->combustible->nombre }}</td>
                    <td>
                        @if ($orden->detalleOrden->medida == 'Litros')
                            {{ $orden->detalleOrden->cantidad }}
                            @php
                                $sumaTotalSolicitadasL += $orden->detalleOrden->cantidad;
                            @endphp
                        @else
                            {{ number_format($orden->detalleOrden->cantidad * 3.785, 2) }}
                            @php
                                $sumaTotalSolicitadasL += $orden->detalleOrden->cantidad * 3.785;
                            @endphp
                        @endif
                    </td>
                    <td>
                        @if ($orden->detalleOrden->medida == 'Galones')
                            {{ $orden->detalleOrden->cantidad }}
                            @php
                                $sumaTotalSolicitadasGal += $orden->detalleOrden->cantidad;
                            @endphp
                        @else
                            {{ number_format($orden->detalleOrden->cantidad / 3.785, 2) }}
                            @php
                                $sumaTotalSolicitadasGal += $orden->detalleOrden->cantidad / 3.785;
                            @endphp
                        @endif
                    </td>
                </tr>

            @endforeach
            <tr>
                <td colspan="7" style="background-color:lightsteelblue;">Total</td>
                <td style="background-color:antiquewhite;">{{ number_format($sumaTotalSolicitadasL, 2) }} Litros</td>
                <td style="background-color:antiquewhite;">{{ number_format($sumaTotalSolicitadasGal, 2) }} Galones</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
