<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Gasolinera;
use App\Models\Persona;
use App\Models\Vehiculo;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteExport;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function ver(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $ordenes = Orden::with([
            'gasolinera',
            'autorizado',
            'relaciones.detalleOrden.vehiculo',
            'relaciones.detalleOrden.chofer',
            'relaciones.detalleOrden.combustible',
        ])->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])->get();
        
        $inicio= $request->fecha_inicio;
        $fin= $request->fecha_fin;

        return view('reportes.resultados', compact('ordenes','inicio','fin'));
    }

    public function pdf(Request $request)
    {
        // Fechas desde el formulario o valores por defecto
        $inicio = $request->input('inicio', now()->startOfMonth()->toDateString());
        $fin = $request->input('fin', now()->endOfMonth()->toDateString());

        // Obtener órdenes con relaciones necesarias
        $ordenes = Orden::with([
            'gasolinera',
            'autorizado',
            'detalles.vehiculo',
            'detalles.chofer',
            'detalles.combustible',
        ])
        ->whereBetween('fecha', [$inicio, $fin])
        ->get();

        // Generar el PDF con la vista
        $pdf = Pdf::loadView('reportes.pdf', [
            'ordenes' => $ordenes,
            'inicio' => $inicio,
            'fin' => $fin,
        ])->setPaper('letter', 'portrait');

        // Descargar o visualizar
        return $pdf->download('reporte-ordenes.pdf');
        // return $pdf->stream(); // <- Para ver en navegador
    }
    
    public function excel(Request $request)
    {
        return Excel::download(new ReporteExport($request->fecha_inicio, $request->fecha_fin), 'reporte_ordenes.xlsx');
    }





    public function cargarOpciones($tipo)
    {
        switch ($tipo) {
            case 'persona':
                $personas = Persona::all(); // Modelo de personas
                return view('reportes.seccionado.opciones.personas', compact('personas'));
            case 'vehiculo':
                $vehiculos = Vehiculo::all();
                return view('reportes.seccionado.opciones.vehiculos', compact('vehiculos'));
            case 'gasolinera':
                $gasolineras = Gasolinera::all();
                return view('reportes.seccionado.opciones.gasolineras', compact('gasolineras'));
            default:
                return '';
        }
    }
    




    public function reporteAvanzadoForm()
    {
        return view('reportes.seccionado.avanzado');
    }

public function reporteAvanzadoVer(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'filtro' => 'required|in:gasolinera,persona,vehiculo',
    ]);

    $filtro = $request->filtro;

    // Base query
    $ordenes = Orden::with([
        'gasolinera',
        'autorizado',
        'relaciones.detalleOrden.vehiculo',
        'relaciones.detalleOrden.chofer',
        'relaciones.detalleOrden.combustible',
    ])
    ->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);

    // Filtro adicional por ID
    switch ($filtro) {
        case 'gasolinera':
            $request->validate(['gasolinera_id' => 'required|exists:gasolineras,id']);
            $ordenes->where('gasolinera_id', $request->gasolinera_id);
            break;

        case 'persona':
            $request->validate(['persona_id' => 'required|exists:personas,id']);
            // Filtramos solo por chofer en las relaciones de detalleOrden
            $ordenes->whereHas('relaciones.detalleOrden', function ($subquery) use ($request) {
                $subquery->where('chofer_id', $request->persona_id);
            });
            break;

        case 'vehiculo':
            $request->validate(['vehiculo_id' => 'required|exists:vehiculos,id']);
            
            // Aseguramos que el filtro se aplica estrictamente al vehiculo_id
            $ordenes->whereHas('relaciones.detalleOrden', function ($query) use ($request) {
                // Aseguramos que solo se filtre por el vehiculo_id
                $query->where('vehiculo_id', $request->vehiculo_id);  
            });
            break;
    }

    $ordenes = $ordenes->get();

    // Agrupación
    $agrupadas = match ($filtro) {
        'gasolinera' => $ordenes->groupBy(fn($orden) =>
            $orden->gasolinera->nombre ?? 'N/D'
        ),

        'persona' => $ordenes->filter(fn($orden) =>
            $orden->autorizado !== null
        )->groupBy(fn($orden) =>
            ($orden->autorizado->primer_nombre ?? '') . ' ' . ($orden->autorizado->primer_apellido ?? '')
        ),

        'vehiculo' => $ordenes->flatMap(function ($orden) use ($request) {
            return $orden->relaciones->filter(function ($rel) use ($request) {
                // Filtramos solo las relaciones donde el vehiculo_id coincida
                return $rel->detalleOrden?->vehiculo?->id == $request->vehiculo_id;
            });
        })->groupBy(fn($rel) =>
            $rel->detalleOrden->vehiculo->placa ?? 'N/D'
        ),

        default => collect()
    };

    return view('reportes.seccionado.avanzado_resultado', compact('agrupadas', 'filtro', 'request'));
}


    public function reporteAvanzadoPDF(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'filtro' => 'required|in:gasolinera,persona,vehiculo',
        ]);
    
        $filtro = $request->filtro;
    
        // Base query
        $ordenes = Orden::with([
            'gasolinera',
            'autorizado',
            'detalles.vehiculo',
            'detalles.chofer',
            'detalles.combustible',
            'relaciones.detalleOrden.vehiculo',
        ])->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
    
        // Filtros por tipo
        switch ($filtro) {
            case 'gasolinera':
                $request->validate(['gasolinera_id' => 'required|exists:gasolineras,id']);
                $ordenes->where('gasolinera_id', $request->gasolinera_id);
                break;
    
        case 'persona':
            $request->validate(['persona_id' => 'required|exists:personas,id']);

            // Filtramos solo por chofer en las relaciones de detalleOrden
            $ordenes->whereHas('relaciones.detalleOrden', function ($subquery) use ($request) {
                $subquery->where('chofer_id', $request->persona_id);
            });
            break;
    
        case 'vehiculo':
            $request->validate(['vehiculo_id' => 'required|exists:vehiculos,id']);
            
            // Aseguramos que el filtro se aplica estrictamente al vehiculo_id
            $ordenes->whereHas('relaciones.detalleOrden', function ($query) use ($request) {
                // Aseguramos que solo se filtre por el vehiculo_id
                $query->where('vehiculo_id', $request->vehiculo_id);  
            });
            break;
        }
    
        // Ejecutar consulta
        $ordenes = $ordenes->get();
    
        // Agrupación
        $agrupadas = match ($filtro) {
            'gasolinera' => $ordenes->groupBy(fn($orden) =>
                $orden->gasolinera->nombre ?? 'N/D'
            ),
    
            'persona' => $ordenes->filter(fn($orden) =>
                $orden->autorizado !== null
            )->groupBy(fn($orden) =>
                ($orden->autorizado->primer_nombre ?? '') . ' ' . ($orden->autorizado->primer_apellido ?? '')
            ),
    
        'vehiculo' => $ordenes->flatMap(function ($orden) use ($request) {
            return $orden->relaciones->filter(function ($rel) use ($request) {
                // Filtramos solo las relaciones donde el vehiculo_id coincida
                return $rel->detalleOrden?->vehiculo?->id == $request->vehiculo_id;
            });
            })->groupBy(fn($rel) =>
                $rel->detalleOrden->vehiculo->placa ?? 'N/D'
            ),
    
            default => collect()
        };
    
        $pdf = Pdf::loadView('reportes.seccionado.pdf', [
            'agrupadas' => $agrupadas,
            'filtro' => $filtro,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
    
        return $pdf->download('reportes-seleccionado.pdf');
    }
    

}
