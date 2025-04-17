<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orden;
use Carbon\Carbon;


class GraficoController extends Controller
{

    public function obtenerDatosGrafico(Request $request)
    {
        // Recibimos las fechas desde la solicitud
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        // Parseamos las fechas de entrada si están presentes
        if ($startDate) {
            $startDate = Carbon::parse($startDate); // Convertimos a objeto Carbon
        }
        
        if ($endDate) {
            $endDate = Carbon::parse($endDate); // Convertimos a objeto Carbon
        }
    
        // Obtener las órdenes con relaciones necesarias (sin agrupar aún)
        $query = Orden::with(['relacionOrdenDetalle.entregado'])
            ->select('orden.*'); // Seleccionamos todas las columnas de la orden
    
        // Filtros de fecha si están presentes
        if ($startDate) {
            $query->whereDate('orden.fecha', '>=', $startDate); // Usamos el objeto Carbon
        }
        
        if ($endDate) {
            $query->whereDate('orden.fecha', '<=', $endDate); // Usamos el objeto Carbon
        }
    
        // Obtener las órdenes
        $ordenes = $query->get();
    
        // Creamos un array donde almacenaremos los resultados
        $resultados = [];
    
        // Iteramos por cada orden
        foreach ($ordenes as $orden) {
            // Asegurándonos de que 'fecha' sea un objeto Carbon
            $fechaOrden = Carbon::parse($orden->fecha);
    
            $mes = $fechaOrden->format('m'); // Extraemos el mes
            $anio = $fechaOrden->format('Y'); // Extraemos el año
    
            // Inicializamos el array si no existe para ese mes/año
            if (!isset($resultados[$anio][$mes])) {
                $resultados[$anio][$mes] = [
                    'total_ordenes' => 0,
                    'entregadas' => 0,
                    'no_entregadas' => 0,
                ];
            }
    
            // Contamos las órdenes, entregadas y no entregadas
            $resultados[$anio][$mes]['total_ordenes']++;
    
            foreach ($orden->relacionOrdenDetalle as $detalle) {
                foreach ($detalle->entregado as $entregado) {
                    if ($entregado->entregado == 1) {
                        $resultados[$anio][$mes]['entregadas']++;
                    } else {
                        $resultados[$anio][$mes]['no_entregadas']++;
                    }
                }
            }
        }
    
        // datos agrupados en el array $resultados, pero lo necesitamos en un formato adecuado
        // array a una colección para ordenar fácilmente por año y mes
        $datos = collect();
    
        foreach ($resultados as $anio => $meses) {
            foreach ($meses as $mes => $datosMes) {
                $datos->push([
                    'year' => $anio,
                    'mes' => $mes,
                    'total_ordenes' => $datosMes['total_ordenes'],
                    'entregadas' => $datosMes['entregadas'],
                    'no_entregadas' => $datosMes['no_entregadas'],
                ]);
            }
        }
    
        // Ordenamos los datos por año y mes
        $datos = $datos->sortBy(['year', 'mes'])->values();
    
        // Devolvemos los resultados como respuesta JSON
        return response()->json($datos);
    }
    
    
    
    
    
    
}
