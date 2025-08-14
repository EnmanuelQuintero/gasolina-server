<?php

namespace App\Exports;

use App\Models\Orden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class ReporteExport implements FromCollection, WithStyles, WithHeadings, ShouldAutoSize
{
    protected $inicio;
    protected $fin;
    protected $data = [];

    public function __construct($inicio, $fin)
    {
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function headings(): array
    {
        return ['#', 'Vehículo', 'Kilometros','Chofer', 'Combustible', 'Cant. Solicitada', 'Cant. Entregada'];
    }

    public function collection()
    {
        // Constante de conversión
        define('LITROS_A_GALONES', 0.264172);

        $ordenes = Orden::with(['gasolinera', 'autorizado', 'relaciones.detalleOrden.vehiculo', 'relaciones.detalleOrden.chofer', 'relaciones.detalleOrden.combustible'])
            ->whereBetween('fecha', [$this->inicio, $this->fin])
            ->get();

        $contador = 1;

        foreach ($ordenes as $orden) {
            // Fila de encabezado para la orden
            $encabezado = [
                'Orden #' . $orden->id,
                'Fecha: ' . $orden->fecha,
                'Gasolinera: ' . ($orden->gasolinera->nombre ?? 'N/D'),
                'Autorizada por: ' . ($orden->autorizado->primer_nombre ?? '') . ' ' . ($orden->autorizado->primer_apellido ?? ''),
                'Observacione: ' . ($orden->observaciones ?? '—'),
                '',
            ];
            $this->data[] = $encabezado;

            foreach ($orden->relaciones as $idx => $relacion) {
                $det = $relacion->detalleOrden;

                $litrosSolic = $det->cantidad;
                $litrosEntreg = $relacion->entregado ? $det->cantidad : 0;

                $galSolic = round($litrosSolic * LITROS_A_GALONES, 2);
                $galEntreg = $relacion->entregado ? round($litrosEntreg * LITROS_A_GALONES, 2) : 'Pendiente';

                $this->data[] = [
                    $contador++,
                    $det->vehiculo->placa ?? 'N/D',
                    $det->kilometros ?? '-',
                    ($det->chofer->primer_nombre ?? '') . ' ' . ($det->chofer->primer_apellido ?? ''),
                    $det->combustible->nombre ?? 'N/D',
                    "{$litrosSolic} L / {$galSolic} gal",
                    is_numeric($galEntreg) ? "{$litrosEntreg} L / {$galEntreg} gal" : 'Pendiente'
                ];
            }
            $contador=1;
        }

        return new Collection($this->data);
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [];

        // Encabezados
        $styles[1] = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => 'center']
        ];

        // Aplicar estilos a encabezados de orden (filas donde la columna A comienza con "Orden #")
        foreach ($this->data as $index => $row) {
            if (isset($row[0]) && str_starts_with($row[0], 'Orden #')) {
                $filaExcel = $index + 2; // +2 porque Excel empieza en 1 y headings ya está en fila 1
                $styles[$filaExcel] = [
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9D9D9']],
                ];
            }
        }

        return $styles;
    }
}
