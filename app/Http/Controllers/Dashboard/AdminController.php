<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ConsolidadoExport;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Persona;
use App\Models\Orden;
use Carbon\Carbon;
use App\Models\DetalleOrden;
use App\Exports\OrdenesExport;
use App\Models\Entregado;
use App\Models\RelacionOrdenDetalle;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de usar esta clase
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    
    public function index()
    {
        // Total de combustible consumido (solo órdenes activas)
        $combustibleConsumido = DetalleOrden::from('detalle_orden')
        ->where('detalle_orden.activo', 1)
        ->whereHas('ordenes', function ($query) {
            $query->where('orden.activo', 1);
        })
        ->sum('cantidad');
    
    
    
        // Total de vehículos activos
        $vehiculosActivos = Vehiculo::where('activo', 1)->count();
    
        // Últimos registros de carga (detalle de orden con relaciones)
        $ultimasCargas = DetalleOrden::with([
            'vehiculo',
            'chofer',
            'combustible',
            'ordenes.gasolinera'
        ])
        ->where('detalle_orden.activo', 1) // 👈 aquí está bien
        ->whereHas('ordenes', function ($query) {
            $query->where('orden.activo', 1); // 👈 especificar tabla
        })
        ->latest()
        ->take(5)
        ->get();
    
    
        // Datos para gráfico mensual de consumo (solo usando Eloquent)
        $consumoMensual = DetalleOrden::where('detalle_orden.activo', 1) // 👈 aquí también
        ->whereHas('ordenes', function ($query) {
            $query->where('orden.activo', 1); // 👈 importante
        })
        ->with('ordenes')
        ->get()
        ->flatMap(function ($detalle) {
            return $detalle->ordenes->map(function ($orden) use ($detalle) {
                return [
                    'mes' => \Carbon\Carbon::parse($orden->fecha)->format('m'),
                    'cantidad' => $detalle->cantidad,
                ];
            });
        })
        ->groupBy('mes')
        ->map(function ($items) {
            return $items->sum('cantidad');
        })
        ->sortKeys();

        $combustibleSolicitado = RelacionOrdenDetalle::where('activo', 1)
        ->with('detalleOrden') // Carga la relación detalleOrden
        ->get() // Obtén todos los resultados
        ->sum(function($relacion) {
            return $relacion->detalleOrden->cantidad; // Accede a la cantidad de la relación
        });
    
    
        $combustibleEntregado = RelacionOrdenDetalle::where('activo', 1)
        ->where('entregado', true)
        ->with('detalleOrden') // Carga la relación detalleOrden
        ->get() // Obtén todos los resultados
        ->map(function($relacion) {
            return $relacion->detalleOrden->cantidad; // Extrae la cantidad de cada relación
        })
        ->sum(); // Suma todas las cantidades
    
    
        return view('admin.dashboard.dashboard', compact(
            'combustibleConsumido',
            'vehiculosActivos',
            'ultimasCargas',
            'consumoMensual',
            'combustibleSolicitado', 
            'combustibleEntregado',
        ));
    }
    
        /**
     * Exporta las órdenes entregadas a Excel filtradas por rango de fechas.
     */
    public function exportDelivered(Request $request, $deliveryStatus)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $tipoCombustible = $request->input('tipo_combustible');
        $tipoOrden = $request->input('tipo_orden');
        $vehiculoId = $request->input('vehiculo_id');
        $areaId = $request->input('area_id');
        $personaId = $request->input('persona_id');
    
        $tipo = $deliveryStatus === 'delivered' ? 'Entregadas' : 'Emitidas';
    
        return Excel::download(
            new OrdenesExport(
                $startDate,
                $endDate,
                true,
                $tipo,
                $tipoCombustible,
                $tipoOrden,
                $vehiculoId,
                $areaId,
                $personaId
            ),
            'ordenes_' . strtolower($tipo) . '.xlsx'
        );
    }
    

    /**
     * Exporta las órdenes basadas en el estado de entrega.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $deliveryStatus
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportOrders(Request $request, $deliveryStatus)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $tipoCombustible = $request->input('tipo_combustible');
        $tipoOrden = $request->input('tipo_orden');
        $vehiculoId = $request->input('vehiculo_id');
        $areaId = $request->input('area_id');
        $personaId = $request->input('persona_id');
    
        $tipo = $deliveryStatus === 'delivered' ? 'Entregadas' : 'Emitidas';
    
        // Validación de fechas
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Por favor, seleccione ambas fechas.');
        }
    
        // Convertir el estado de entrega a booleano
        $delivered = $deliveryStatus === 'delivered';
    
        // Logos en base64 (si los usas en el exportador)
        $image = base64_encode(file_get_contents(public_path('images/logo.jpeg')));
        $image45 = base64_encode(file_get_contents(public_path('images/logo45_sf.png')));
    
        return Excel::download(
            new OrdenesExport(
                $startDate,
                $endDate,
                $delivered,
                $tipo,
                $tipoCombustible,
                $tipoOrden,
                $vehiculoId,
                $areaId,
                $personaId
            ),
            'ordenes_' . strtolower($tipo) . '.xlsx'
        );
    }
    

    public function exportPdf(Request $request, $deliveryStatus)
    {
        // Verifica si las fechas están presentes
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Si alguna de las fechas no está presente, redirige con un mensaje de error
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Por favor, seleccione ambas fechas.');
        }
    
        $delivered = $deliveryStatus === 'delivered' ? 1 : 0;
    
        $orders = Orden::with([
            'detalles.vehiculo.marca',
            'detalles.vehiculo.modelo',
            'detalles.chofer',
            'detalles.combustible',
            'gasolinera',
            'autorizado.area',
            'autorizado.cargo'
        ])
        ->whereBetween('fecha', [$startDate, $endDate])
        ->where('entregada', $delivered)
        ->get();
    

        $reporte = $deliveryStatus === 'delivered' ? "Reporte de Ordenes Entregadas". PHP_EOL .  " del " .$startDate.' al '.$endDate : 'Reporte de Ordenes Emitidas del '.$startDate.' al '.$endDate;

        // Verifica la estructura de datos y relaciones cargadas
        //dd($orders->toArray());
        $image = base64_encode(file_get_contents(public_path('images/logo.jpeg')));
        $image45 = base64_encode(file_get_contents(public_path('images/logo45_sf.png')));
        $fecha = Carbon::now()->format('d-m-Y'); // Puedes usar cualquier formato que desees
    
        $pdf = Pdf::loadView('pdf.orders', [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reporte'=> $reporte,
            'image'=> $image,
            'image45'=> $image45,
            'fecha'=> $fecha
        ]);
    
        return $pdf->download('ordenes_export.pdf');
    }
    
    public function verReporte(Request $request, $deliveryStatus)
    {
        // Verifica si las fechas están presentes
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Si alguna de las fechas no está presente, redirige con un mensaje de error
        if (!$startDate || !$endDate) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Por favor, seleccione ambas fechas.');
        }
    
        $delivered = $deliveryStatus === 'delivered' ? 1 : 0;
    
        $orders = Orden::with([
            'detalles.vehiculo.marca',
            'detalles.vehiculo.modelo',
            'detalles.chofer',
            'detalles.combustible',
            'gasolinera',
            'autorizado.area',
            'autorizado.cargo'
        ])
        ->whereBetween('fecha', [$startDate, $endDate])
        ->where('entregada', $delivered)
        ->get();
        $reporte = $deliveryStatus === 'delivered' ? "Reporte de Ordenes Entregadas". PHP_EOL .  " del " .$startDate.' al '.$endDate : 'Reporte de Ordenes Emitidas del '.$startDate.' al '.$endDate;
    

        $image = base64_encode(file_get_contents(public_path('images/logo.jpeg')));
        $image45 = base64_encode(file_get_contents(public_path('images/logo45_sf.png')));
        $fecha = Carbon::now()->format('d-m-Y'); // Puedes usar cualquier formato que desees

        // Verifica la estructura de datos y relaciones cargadas
        //dd($orders->toArray());
        return view('pdf.vista.orders',compact('orders','reporte','image','image45','fecha') );

    }

    public function consolidadoExcel(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $tipo = $request->input('tipo');
    
        $tipoCombustible = $request->input('tipo_combustible');
        $tipoOrden = $request->input('tipo_orden');
        $vehiculoId = $request->input('vehiculo_id');
        $areaId = $request->input('area_id');
        $personaId = $request->input('persona_id');
    
        // Consulta base para ordenes por día
        $ordenesPorDiaQuery = Orden::selectRaw(
            'orden.fecha,
            COUNT(orden.id) as total_ordenes,
            GROUP_CONCAT(orden.id) as ids,
            GROUP_CONCAT(orden.autorizado_id) as ids_autorizado,
            GROUP_CONCAT(entregado.entregado) as entregado'
        )
        ->join('relacion_orden_detalle', 'orden.id', '=', 'relacion_orden_detalle.orden_id')
        ->join('entregado', 'relacion_orden_detalle.id', '=', 'entregado.relacion_orden_detalle_id')
        ->whereBetween('orden.fecha', [$startDate, $endDate])
        ->where('entregado.entregado', 1);
    
        // Aplicar filtros si están presentes
        if ($tipoCombustible) {
            $ordenesPorDiaQuery->where('orden.tipo_combustible', $tipoCombustible);
        }
    
        if ($tipoOrden) {
            $ordenesPorDiaQuery->where('orden.tipo_orden', $tipoOrden);
        }
    
        if ($vehiculoId) {
            $ordenesPorDiaQuery->where('orden.vehiculo_id', $vehiculoId);
        }
    
        if ($areaId) {
            $ordenesPorDiaQuery->where('orden.area_id', $areaId);
        }
    
        if ($personaId) {
            $ordenesPorDiaQuery->where('orden.autorizado_id', $personaId);
        }
    
        $ordenesPorDia = $ordenesPorDiaQuery
            ->groupBy('orden.fecha')
            ->orderBy('orden.fecha')
            ->get();
    
        // Consulta base para detalles
        $detallesQuery = DetalleOrden::join('relacion_orden_detalle', 'detalle_orden.id', '=', 'relacion_orden_detalle.detalle_orden_id')
            ->join('orden', 'relacion_orden_detalle.orden_id', '=', 'orden.id')
            ->join('entregado', 'relacion_orden_detalle.id', '=', 'entregado.relacion_orden_detalle_id')
            ->select('detalle_orden.*')
            ->whereBetween('orden.fecha', [$startDate, $endDate])
            ->where('entregado.entregado', 1);
    
        // Aplicar los mismos filtros
        if ($tipoCombustible) {
            $detallesQuery->where('orden.tipo_combustible', $tipoCombustible);
        }
    
        if ($tipoOrden) {
            $detallesQuery->where('orden.tipo_orden', $tipoOrden);
        }
    
        if ($vehiculoId) {
            $detallesQuery->where('orden.vehiculo_id', $vehiculoId);
        }
    
        if ($areaId) {
            $detallesQuery->where('orden.area_id', $areaId);
        }
    
        if ($personaId) {
            $detallesQuery->where('orden.autorizado_id', $personaId);
        }
    
        $detalles = $detallesQuery->get();
    
        return Excel::download(
            new ConsolidadoExport($startDate, $endDate, $tipo, $tipoCombustible, $tipoOrden, $vehiculoId, $areaId, $personaId),
            'consolidado_ordenes.xlsx'
        );
    }
    

    public function consolidadoPDF(Request $request)
    {
        $ordenes = Orden::all();
        $detalles = DetalleOrden::all();
        $image = base64_encode(file_get_contents(public_path('images/logo.jpeg')));
        $image45 = base64_encode(file_get_contents(public_path('images/logo45_sf.png')));
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $fecha = Carbon::now()->format('d-m-Y'); // Puedes usar cualquier formato que desees

        
        $reporte =  "Reporte Consolidado de Ordenes ". PHP_EOL .  " del " .$startDate.' al '.$endDate ;
        // Total de órdenes por día
        $ordenesPorDia = Orden::selectRaw(
            'fecha, 
            COUNT(id) as total_ordenes, 
            GROUP_CONCAT(id) as ids, 
            GROUP_CONCAT(id_autorizado) as ids_autorizado, 
            GROUP_CONCAT(entregada) as entregadas'
        )
        ->whereBetween('fecha', [$startDate, $endDate])
        ->where('entregada', 1)
        ->groupBy('fecha')
        ->orderBy('fecha')
        ->get();



        $pdf = Pdf::loadView('pdf.consolidado', compact('ordenes','ordenesPorDia', 'detalles', 'startDate','reporte' ,'endDate','image','fecha','image45'));

        return $pdf->download('pdf.consolidado');
    }

    public function verConsolidado(Request $request, $startDate, $endDate)
    {
        $unit = $request->input('unit', 'Litros');
    
        // Filtros
        $tipoCombustible = $request->input('tipo_combustible');
        $tipoOrden = $request->input('tipo_orden');
        $vehiculoId = $request->input('vehiculo_id');
        $areaId = $request->input('area_id');
        $personaId = $request->input('persona_id');
    
        $image = base64_encode(file_get_contents(public_path('images/logo.jpeg')));
        $image45 = base64_encode(file_get_contents(public_path('images/logo45_sf.png')));
        $fecha = Carbon::now()->format('d-m-Y');
        $reporte = "Reporte Consolidado de Órdenes \n del $startDate al $endDate";
    
        // Todas las relaciones filtradas
        $relaciones = RelacionOrdenDetalle::with(['orden', 'detalleOrden'])
            ->whereHas('orden', function ($q) use ($startDate, $endDate, $tipoCombustible, $tipoOrden, $vehiculoId, $areaId, $personaId) {
                $q->whereBetween('fecha', [$startDate, $endDate])
                    ->when($tipoCombustible, fn($q) => $q->where('tipo_combustible', $tipoCombustible))
                    ->when($tipoOrden, fn($q) => $q->where('tipo_orden', $tipoOrden))
                    ->when($vehiculoId, fn($q) => $q->where('vehiculo_id', $vehiculoId))
                    ->when($areaId, fn($q) => $q->where('area_id', $areaId))
                    ->when($personaId, fn($q) => $q->where('autorizado_id', $personaId));
            })
            ->get();
    
        // Separar entregadas y no entregadas
        $relacionesEntregadas = $relaciones->where('entregado', 1);
        $relacionesNoEntregadas = $relaciones->where('entregado', 0);
    
        // Agrupar resumen por fecha
        $ordenesPorDia = $relaciones->groupBy(fn($item) => $item->orden->fecha)->map(function ($items, $fecha) {
            return [
                'fecha' => $fecha,
                'total_ordenes' => $items->count(),
                'total_solicitado' => $items->sum(fn($i) => $i->detalleOrden->cantidad),
                'total_entregado' => $items->where('entregado', 1)->sum(fn($i) => $i->detalleOrden->cantidad),
                'medida' => $items->first()?->detalleOrden?->medida ?? 'Litros',
            ];
        })->values()->toArray();
    

        // Variables base
        $totalOrdenes = $relaciones->count();
        $totalSolicitadoLitros = 0;
        $totalEntregadoLitros = 0;

        // Calcular totales en litros usando 'if'
        foreach ($relaciones as $r) {
            $cantidad = $r->detalleOrden->cantidad;
            $medida = strtolower($r->detalleOrden->medida);

            if ($medida === 'galones') {
                $totalSolicitadoLitros += $cantidad * 3.78541;
            } else {
                $totalSolicitadoLitros += $cantidad;
            }
        }

        foreach ($relacionesEntregadas as $r) {
            $cantidad = $r->detalleOrden->cantidad;
            $medida = strtolower($r->detalleOrden->medida);

            if ($medida === 'galones') {
                $totalEntregadoLitros += $cantidad * 3.78541;
            } else {
                $totalEntregadoLitros += $cantidad;
            }
        }

        // Convertimos también a galones
        $totalSolicitadoGalones = $totalSolicitadoLitros / 3.78541;
        $totalEntregadoGalones = $totalEntregadoLitros / 3.78541;
        $porcentajeEntregado = $totalSolicitadoLitros > 0 ? round(($totalEntregadoLitros / $totalSolicitadoLitros) * 100, 2) : 0;





        return view('pdf.vista.consolidado', [
            'ordenes' => $ordenesPorDia,
            'relacionesFiltradas' => $relacionesEntregadas,
            'relacionesNoEntregadas' => $relacionesNoEntregadas,
            'fecha' => $fecha,
            'reporte' => $reporte,
            'image' => $image,
            'image45' => $image45,
            'resumenGeneral' => [
                'total_ordenes' => $totalOrdenes,
                'litros_solicitado' => $totalSolicitadoLitros,
                'litros_entregado' => $totalEntregadoLitros,
                'galones_solicitado' => $totalSolicitadoGalones,
                'galones_entregado' => $totalEntregadoGalones,
                'porcentaje_entregado' => $porcentajeEntregado
            ]
        ]);
        
    }
    
    
    
    
    
}