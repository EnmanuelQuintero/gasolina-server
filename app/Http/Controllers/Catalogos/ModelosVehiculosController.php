<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Models\Modelo;
use App\Models\RelacionMarcaModelo;
use App\Models\Vehiculo;

class ModelosVehiculosController extends Controller
{
    public function index(Request $request)
    {
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $marcasModelos = RelacionMarcaModelo::with(['marca', 'modelo'])->get();

        $vehiculos = Vehiculo::with('marcaModelo.marca', 'marcaModelo.modelo')
            ->when($request->placa, function ($query, $placa) {
                return $query->where('placa', 'LIKE', "%{$placa}%");
            })
            ->when($request->tipo, function ($query, $tipo) {
                return $query->where('tipo', $tipo);
            })
            ->when($request->color, function ($query, $color) {
                return $query->where('color', $color);
            })
            ->when($request->estado, function ($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->when($request->marca_id, function ($query, $marcaId) {
                return $query->whereHas('marcaModelo.marca', function ($q) use ($marcaId) {
                    $q->where('id', $marcaId);
                });
            })
            ->when($request->modelo_id, function ($query, $modeloId) {
                return $query->whereHas('marcaModelo.modelo', function ($q) use ($modeloId) {
                    $q->where('id', $modeloId);
                });
            })
            ->get();

        return view('vehiculo.marcaModelo', compact('marcas', 'vehiculos', 'modelos', 'marcasModelos'));
    }

    public function create()
    {
        $nombre = 'Modelo de Vehiculo';
        $ruta_store = route('modelos-vehiculos.store');
        return view('vista_generica.vista_crear', compact('ruta_store', 'nombre'));
    }


    public function store(Request $request)
    {
        // Validar la entrada para el modelo
        $request->validate([
            'modelo' => 'required|string|max:255',
            'marca_id' => 'required|exists:marcas,id',
        ]);

        // Crear el nuevo modelo
        $modelo = Modelo::create([
            'nombre' => $request->modelo,
        ]);

        // Crear la relación entre la marca y el modelo
        RelacionMarcaModelo::create([
            'marca_id' => $request->marca_id,
            'modelo_id' => $modelo->id,
            'activo' => 1, // Asumimos que por defecto es activo
        ]);

        $marcas = Marca::all();
        $vehiculos = Vehiculo::all();
        $modelos = Modelo::all();
        $marcasModelos = RelacionMarcaModelo::all(); 
        return view('vehiculo.marcaModelo', compact('marcas', 'vehiculos', 'marcasModelos', 'modelos'));
    }


    public function edit($id)
    {

        $ruta_edit = route('modelos-vehiculos.update', ['modelos_vehiculo' => 'dummy']);

        $dato = Modelo::findOrFail($id);
        return view('vista_generica.vista_edicion', compact('dato','ruta' ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $modeloVehiculo = Modelo::findOrFail($id);
        $modeloVehiculo->update($request->all());
        return redirect()->route('modelos-vehiculos.index')->with('success', 'Modelo de vehículo actualizado exitosamente.');
    }

    public function estado($id)
    {
        // Buscar la gasolinera por su ID
        $dato = Modelo::findOrFail($id);

        // Cambiar el campo activo

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('modelos-vehiculos.index')->with('success', 'El modelo de vehiculo ha sido activado.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('modelos-vehiculos.index')->with('success', 'El modelo de vehiculo ha sido desactivado.');
        }




    }
}
