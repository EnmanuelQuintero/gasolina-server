<?php

namespace App\Http\Controllers\Orden;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\DetalleOrden;
use App\Models\Combustible;
use App\Models\Vehiculo;
use App\Models\Gasolinera;
use App\Models\Persona;
use App\Models\RelacionOrdenDetalle;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use App\Models\Entregado;

class OrdenController extends Controller
{
    // Método para mostrar la lista de órdenes
// OrdenController.php

public function index(Request $request)
{
    
    //dd($request->all());
    $ordenes = Orden::all();
    $detalles = DetalleOrden::all();
    if (isset($request->search) ) {
        $ordenes = Orden::where('token', $request->search)->get();
        dd($ordenes);
    }
    // Retorna la vista con las órdenes filtradas, buscadas y ordenadas
    return view('orden.orden.index', compact('ordenes', 'detalles'));
}



    public function nueva()
    {
        $gasolineras = Gasolinera::all();
        $personas = Persona::all();
        $vehiculos = Vehiculo::all();
        $combustibles = Combustible::all();

        return view('orden.orden.create', compact('gasolineras', 'personas', 'vehiculos', 'combustibles'));
    }
    
    
    public function create()
    {
        $gasolineras = Gasolinera::all();
        $personas = Persona::all();
        $vehiculos = Vehiculo::all();
        $combustibles = Combustible::all();

        return view('orden.orden.create', compact('gasolineras', 'personas', 'vehiculos', 'combustibles'));
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $orden = Orden::create([
            'fecha' => $request->fecha,
            'gasolinera_id' => $request->id_gasolinera,
            'autorizado_id' => $request->id_autorizado,
            'observaciones' => $request->observaciones,
            'token' => bin2hex(openssl_random_pseudo_bytes(8)),
        ]);
    
        foreach ($request->detalles as $detalle) {
            $detalleguardar = DetalleOrden::create([
                'vehiculo_id' => $detalle['numero_placa'],
                'chofer_id' => $detalle['id_chofer'],
                'combustible_id' => $detalle['id_combustible'],
                'cantidad' => $detalle['cantidad'],
                'medida' => $request->medida,
            ]);

            // Crear la relación entre la marca y el modelo
            RelacionOrdenDetalle::create([
                'activo' => 1, // Asumimos que por defecto es activo
                'orden_id' => $orden->id,
                'detalle_orden_id' => $detalleguardar->id,

            ]);
        }


    
        return redirect()->route('orden.index')->with('success', 'Orden creada con éxito.');
    }

    // Muestra el formulario para editar una orden
    public function edit($id)
    {

        $orden = Orden::findOrFail($id);
       // Extrae la relación detalle de orden sin paginar para evitar problemas con `currentPage`
        $relacionDetalleOrden = RelacionOrdenDetalle::where('orden_id', $orden->id)->with('detalleOrden')->get();

        foreach ($relacionDetalleOrden as $relacion) {
            $medida=$relacion->detalleOrden->medida;
            break;
        }

        // Verifica que los detalles estén correctamente obtenidos
        if (!$relacionDetalleOrden) {
            return redirect()->back()->with('error', 'No se encontraron detalles para esta orden.');
        }
        //dd($relacionDetalleOrden);
        $gasolineras = Gasolinera::all();
        $personas = Persona::all();
        $vehiculos = Vehiculo::all();
        $combustibles = Combustible::all();

        return view('orden.orden.edit', compact('medida','orden', 'gasolineras', 'personas', 'relacionDetalleOrden' ,'vehiculos', 'combustibles'));
    }
    // Actualiza una orden en el almacenamiento
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'nullable|date',
            'id_gasolinera' => 'nullable|exists:gasolineras,id',
            'id_autorizado' => 'nullable|exists:personas,id',
            'observaciones' => 'nullable|string',
            'detalles.*.numero_placa' => 'nullable|string',
            'detalles.*.id_chofer' => 'nullable|exists:personas,id',
            'detalles.*.id_combustible' => 'nullable|exists:combustibles,id',
            'detalles.*.cantidad' => 'nullable|numeric',
            'detalles.*.medida' => 'nullable|string|in:Litros,Galones',
        ]);
    
        // Encuentra la orden que se va a actualizar
        $orden = Orden::findOrFail($id);
    
        // Actualiza los datos de la orden
        $orden->update([
            'fecha' => $request->input('fecha'),
            'gasolinera_id' => $request->input('id_gasolinera'),
            'autorizado_id' => $request->input('id_autorizado'),
            'observaciones' => $request->input('observaciones'),
            'activo' => 1, // Cambia esto según tu lógica
        ]);
    
        // Obtén los detalles del request
        $detalles = $request->input('detalles', []);
    
        foreach ($detalles as $detalle) {
            // Verifica si el detalle existe
            if (isset($detalle['id'])) {
                // Actualiza el detalle existente
                $detalleOrden = DetalleOrden::findOrFail($detalle['id']);
                $detalleOrden->update([
                    'vehiculo_id' => $detalle['numero_placa'],
                    'chofer_id' => $detalle['id_chofer'],
                    'combustible_id' => $detalle['id_combustible'],
                    'cantidad' => $detalle['cantidad'],
                    'medida' => $request->medida,
                ]);
            } else {
                // Crea un nuevo detalle si no se proporciona un ID
                DetalleOrden::create([
                    'vehiculo_id' => $detalle['numero_placa'],
                    'chofer_id' => $detalle['id_chofer'],
                    'combustible_id' => $detalle['id_combustible'],
                    'cantidad' => $detalle['cantidad'],
                    'medida' => $request->medida,
                ]);
            }
        }
    
        return redirect()->route('orden.index')->with('success', 'Orden actualizada con éxito.');
    }
    
    

    public function generateQRCode($token)
    {
        // Genera el código QR
        $qrCode = QrCode::format('png')->size(70)->generate($token);
    
        // Devuelve el código QR como imagen PNG
        return response($qrCode)->header('Content-Type', 'image/png');
    }
    


    public function show($id)
    {
        $orden = Orden::with('gasolinera', 'autorizado')->findOrFail($id);

        return response()->json([
            'id' => $orden->id,
            'fecha' => $orden->fecha,
            'gasolinera' => $orden->gasolinera,
            'autorizado' => $orden->autorizado,
            'observaciones' => $orden->observaciones,
            'detalles' => $orden->detalles,
        ]);
    }


    public function entregar($id)
    {
        $orden = Orden::with(['detalles'])->findOrFail($id);

        // Obtener los detalles desde la tabla pivote
        $relaciones = RelacionOrdenDetalle::with('detalleOrden')
                        ->where('orden_id', $id)
                        ->get();

        return view('orden.entrega.detalles', compact('orden', 'relaciones'));
    }
    

    public function entregarMultiples(Request $request)
    {
        $ids = $request->input('detalles', []);
    
        if (count($ids) === 0) {
            return back()->with('success', 'No seleccionaste ningún detalle.');
        }
    
        RelacionOrdenDetalle::whereIn('id', $ids)->update([
            'entregado' => true,
            'fecha_entrega' => now(),
        ]);
    
        return back()->with('success', 'Detalles marcados como entregados exitosamente.');
    }
    

    

    public function estado($id)
    {
        // Buscar la gasolinera por su ID
        $dato = Orden::findOrFail($id);

        // Cambiar el campo activo

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('orden.index')->with('success', 'El registro de la orden ha sido activada.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('orden.index')->with('success', 'El registro de la orden ha sido eliminada.');
        }




    }

    public function mostrarDetalles($id)
    {
        $orden = Orden::findOrFail($id);
        $relacionDetalleOrden = RelacionOrdenDetalle::where('orden_id', $orden->id)->paginate(11);
    
        return view('orden.orden.detalles', compact('relacionDetalleOrden', 'orden'));
    }
    





}
