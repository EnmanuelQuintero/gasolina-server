<?php

namespace App\Http\Controllers\Informes;

use App\Http\Controllers\Controller;
use App\Models\Entregado;
use App\Models\Orden;
use App\Models\RelacionOrdenDetalle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Exports\OrdenesExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InformeController extends Controller
{
    
    public function generarReporte($startDate, $endDate)
    {
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get(); // obtener las órdenes
        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])->get(); // obtener las entregas
        $relaciones = RelacionOrdenDetalle::all(); // obtener las relaciones
    
        $startDate = Carbon::parse($startDate)->format('d / m / Y'); // Formato: día - mes - año
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
    
        // Pasar los datos a la vista
        $pdf = PDF::loadView('reporte.pdf.pdf', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));
    
        // Descargar el PDF
        return $pdf->download('reporte_consolidado_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    //funcion para generar informe en excel
    public function generarExcel($startDate, $endDate)
    {

    // Obtener los datos de la base de datos
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get();
        $relaciones = RelacionOrdenDetalle::all();
        $entregadas = Entregado::all();

        // Crear un nuevo Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte Consolidado');

        // Establecer título y encabezado de la hoja
        $sheet->setCellValue('A1', 'Alcaldía Municipal de Leon');
        $sheet->setCellValue('A2', 'Reporte Consolidado');
        $sheet->setCellValue('A3', "{$startDate} - {$endDate}");

        // Juntar celdas en la parte superior para el título
        $sheet->mergeCells('A1:G1'); // Juntar de la celda A1 a la G1
        $sheet->mergeCells('A2:G2'); // Juntar de la celda A2 a la G2
        $sheet->mergeCells('A3:G3'); // Juntar de la celda A3 a la G3

        // Centrar el texto en las celdas fusionadas
        $sheet->getStyle('A1:G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        // Insertar imágenes si existen
        $this->insertarImagen($sheet, 'A1', 'images/logo.png', 80);
        $this->insertarImagen($sheet, 'G1', 'images/logo45_sf.png', 80);

        // Establecer los encabezados de la tabla
        $sheet->setCellValue('A5', 'Fecha Solicitada');
        $sheet->setCellValue('B5', 'Fecha Entregada');
        $sheet->setCellValue('C5', '# Orden');
        $sheet->setCellValue('D5', 'Total Emitido (Litros)');
        $sheet->setCellValue('E5', 'Total Emitido (Galones)');
        $sheet->setCellValue('F5', 'Total Entregado (Litros)');
        $sheet->setCellValue('G5', 'Total Entregado (Galones)');

        // Ajustar el ancho de las columnas según el contenido
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);


        // Insertar datos de las órdenes y relaciones
        $row = 6;
        $sumaTotalSolicitadasL = 0;
        $sumaTotalSolicitadasGal = 0;
        $sumaTotalEntregadasL = 0;
        $sumaTotalEntregadasGal = 0;

        foreach ($ordenes as $orden) {
            $totalSolicitadoL = 0;
            $totalSolicitadoGal = 0;
            $totalEntregadoL = 0;
            $totalEntregadoGal = 0;
            $fechaEntregada = null; // Almacena la fecha de la entrega
        
            foreach ($relaciones as $relacion) {
                if ($relacion->orden_id == $orden->id) {
                    $this->calcularTotales($relacion, $totalSolicitadoL, $totalSolicitadoGal);
                }
            }
        
            foreach ($entregadas as $entregada) {
                if ($entregada->relacionOrdenDetalle->orden_id == $orden->id && $entregada->entregado == 1) {
                    $this->calcularTotales($entregada->relacionOrdenDetalle, $totalEntregadoL, $totalEntregadoGal, true);
        
                    // Tomar la primera fecha de entrega válida
                    if (!$fechaEntregada) {
                        $fechaEntregada = $entregada->fecha;
                    }
                }
            }
        
            // Llenar los datos en la hoja
            $sheet->setCellValue('A' . $row, $orden->fecha); // Fecha Solicitada
            $sheet->setCellValue('B' . $row, $fechaEntregada ?: 'Pendiente'); // Fecha Entregada
            $sheet->setCellValue('C' . $row, $orden->id); // # Orden
            $sheet->setCellValue('D' . $row, number_format($totalSolicitadoL, 2)); // Total Emitido (Litros)
            $sheet->setCellValue('E' . $row, number_format($totalSolicitadoGal, 2)); // Total Emitido (Galones)
            $sheet->setCellValue('F' . $row, number_format($totalEntregadoL, 2)); // Total Entregado (Litros)
            $sheet->setCellValue('G' . $row, number_format($totalEntregadoGal, 2)); // Total Entregado (Galones)
        
            $sumaTotalSolicitadasL += $totalSolicitadoL;
            $sumaTotalSolicitadasGal += $totalSolicitadoGal;
            $sumaTotalEntregadasL += $totalEntregadoL;
            $sumaTotalEntregadasGal += $totalEntregadoGal;
        
            $row++;
        }
        

        // Totales
        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->setCellValue('D' . $row, number_format($sumaTotalSolicitadasL, 2));
        $sheet->setCellValue('E' . $row, number_format($sumaTotalSolicitadasGal, 2));
        $sheet->setCellValue('F' . $row, number_format($sumaTotalEntregadasL, 2));
        $sheet->setCellValue('G' . $row, number_format($sumaTotalEntregadasGal, 2));

        // Establecer los bordes de las celdas
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
        $sheet->getStyle('A5:G' . $row)->applyFromArray($styleArray);

        // Crear el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'reporte_consolidado_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Enviar el archivo Excel al navegador
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }



    // Función para insertar imágenes
    private function insertarImagen($sheet, $coordinates, $path, $height)
    {
        if (file_exists(public_path($path))) {
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo');
            $drawing->setPath(public_path($path)); // Ruta de la imagen
            $drawing->setHeight($height);
            $drawing->setCoordinates($coordinates);
            $drawing->setWorksheet($sheet);
        }
    }

    // Función para calcular totales
    private function calcularTotales($detalle, &$totalL, &$totalGal, $esEntregado = false)
    {
        $cantidad = $detalle->detalleOrden->cantidad;
        $medida = $detalle->detalleOrden->medida;

        if ($medida == 'Litros') {
            $totalL += $cantidad;
        } else {
            $totalL += $cantidad * 3.785; // Conversion a Litros
        }

        if ($medida == 'Galones') {
            $totalGal += $cantidad;
        } else {
            $totalGal += $cantidad / 3.785; // Conversion a Galones
        }
    }
    


    public function verReporteSolicitadas($startDate, $endDate)
    {
        // Obtener las órdenes
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get();
        
        // Obtener las entregas (entregadas con entrega pendiente)
        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])
                                ->where('entregado', 0) // Solo entregas pendientes
                                ->get();
        //dd($entregadas);
        // Obtener las relaciones de orden
        $relaciones = RelacionOrdenDetalle::all();
        //dd($relaciones);
        // Formatear las fechas a un formato amigable (d / m / Y)
        $startDate = Carbon::parse($startDate)->format('d / m / Y');
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
    


        // Cargar la vista que quieres convertir a PDF
        return view('reporte.vista.pdfSolicitadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));

        // Descargar el PDF
        //return $pdf->download('reporte_informe.pdf');        // Pasar los datos a la vista para que se muestren en pantalla
        
    }

    public function generarReporteSolicitadas($startDate, $endDate)
    {
        // Obtener las órdenes
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get();
        
        // Obtener las entregas (entregadas con entrega pendiente)
        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])
                                ->where('entregado', 0) // Solo entregas pendientes
                                ->get();
        
        // Obtener las relaciones de orden
        $relaciones = RelacionOrdenDetalle::all();
    
        // Formatear las fechas a un formato amigable (d / m / Y)
        $startDate = Carbon::parse($startDate)->format('d / m / Y');
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
    
        // Generar el PDF usando la vista
        $pdf = PDF::loadView('reporte.pdf.pdfSolicitadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));
    
        // Descargar el PDF
        return $pdf->download('reporte_Solicitadas_' . date('Y-m-d_H-i-s') . '.pdf');
    }
    

    public function verReporteEntregadas($startDate, $endDate)
    {

        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])->where('entregado', 1)->get(); /* obtener las entregas */;
        // Si $entregadas está vacío, redirige de vuelta con un mensaje de error
        if ($entregadas->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron entregas para el rango de fechas seleccionado.');
        }
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get(); /* obtener las órdenes */;
        
        $relaciones = RelacionOrdenDetalle::all(); /* obtener las relaciones */;
            //dd($relaciones);



        $startDate = Carbon::parse($startDate)->format('d / m / Y'); // Formato: día - mes - año
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
        return view('reporte.vista.pdfentregadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));

    }
    
    public function generarReporteEntregadas($startDate, $endDate)
    {

        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])->where('entregado', 1)->get(); /* obtener las entregas */;
        // Si $entregadas está vacío, redirige de vuelta con un mensaje de error
        if ($entregadas->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron entregas para el rango de fechas seleccionado.');
        }
        if (!$startDate || !$endDate || !Carbon::hasFormat($startDate, 'Y-m-d') || !Carbon::hasFormat($endDate, 'Y-m-d')) {
            return redirect()->back()->with('error', 'Las fechas proporcionadas no son válidas.');
        }
        
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get(); /* obtener las órdenes */;
        
        $relaciones = RelacionOrdenDetalle::all(); /* obtener las relaciones */;
            //dd($relaciones);



        $startDate = Carbon::parse($startDate)->format('d / m / Y'); // Formato: día - mes - año
        $endDate = Carbon::parse($endDate)->format('d / m / Y');

        // Pasar los datos a la vista
        $pdf = PDF::loadView('reporte.pdf.pdfentregadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));

        // Descargar el PDF
        return $pdf->download('reporte_Entregados_' . date('Y-m-d_H-i-s') . '.pdf');

    }

    public function generarExcelSolicitadas($startDate,$endDate)
    {
        //dd($startDate,$endDate);

        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get(); // Obtener las órdenes
        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])->where('entregado', 0)->get(); // Obtener las entregas
        //dd($ordenes);

        $relaciones = RelacionOrdenDetalle::all(); /* obtener las relaciones */;
        $startDate = Carbon::parse($startDate)->format('d / m / Y'); // Formato: día - mes - año
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
        return view('reporte.excel.excelSolicitadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));

    }

    public function generarExcelEntregadas($startDate, $endDate)
    {

        $entregadas = Entregado::whereBetween('fecha', [$startDate, $endDate])->where('entregado', 1)->get(); /* obtener las entregas */;
        // Si $entregadas está vacío, redirige de vuelta con un mensaje de error
        if ($entregadas->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron entregas para el rango de fechas seleccionado.');
        }
        $ordenes = Orden::whereBetween('fecha', [$startDate, $endDate])->get(); /* obtener las órdenes */;
        
        $relaciones = RelacionOrdenDetalle::all(); /* obtener las relaciones */;

        $startDate = Carbon::parse($startDate)->format('d / m / Y'); // Formato: día - mes - año
        $endDate = Carbon::parse($endDate)->format('d / m / Y');
        return view('reporte.excel.excelEntregadas', compact('ordenes', 'entregadas', 'relaciones', 'startDate', 'endDate'));

    }

    
}
