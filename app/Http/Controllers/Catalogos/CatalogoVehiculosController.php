<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator; // Asegúrate de importar Validator

class CatalogoVehiculosController extends Controller
{
public function index(Request $request)
{
    $marcas = Marca::all();
    $modelos = Modelo::all();

    $tipos = [
        'Automovil' => 'Automovil',
        'Camioneta' => 'Camioneta',
        'Motocicleta' => 'Motocicleta',
        'Camion' => 'Camion',
        'Otro' => 'Otro'
    ];

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

    return view('catalogos.vehiculos.index', compact('vehiculos', 'tipos', 'marcas', 'modelos'));
}

    public function create()
    {
        $marcas = Marca::all();
        $modelos = Modelo::all();
        $tipos = [
            'Automovil' => 'Automovil',
            'Camioneta' => 'Camioneta',
            'Moto' => 'Moto',
            'Camion' => 'Camion',
            'Otro' => 'Otro'
        ];
        return view('catalogos.vehiculos.create', compact('marcas', 'modelos', 'tipos'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'tipo' => 'required|string|max:255',
            'relacion_marca_modelo_id' => 'required|exists:relacion_marca_modelo,id',
            'color' => 'required',
            'placa' => 'required|string|max:12|unique:vehiculos,placa',
        ]);

        Vehiculo::create($request->all());
        return redirect()->route('modelos-vehiculos.index')->with('success', 'Vehículo creado exitosamente.');
    }

    public function show($id)
    {
        // Busca el vehículo por su ID
        $vehiculo = Vehiculo::find($id);
        
        // Si no se encuentra, puedes retornar un error o una respuesta vacía
        if (!$vehiculo) {
            return response()->json(['error' => 'Vehículo no encontrado'], 404);
        }

        // Retorna los datos del vehículo
        return response()->json($vehiculo);
    }
    // Muestra el formulario para editar un vehículo existente
    public function edit($id)
    {
        // Encontrar el vehículo en la base de datos
        $catalogoVehiculo = Vehiculo::findOrFail($id);
    
        // Obtener las opciones para el campo 'tipo' (esto depende de cómo lo manejes en tu aplicación)
        $tipos = [
            'automovil' => 'Automovil',
            'Camioneta' => 'Camioneta',
            'Motocicleta' => 'Motocicleta',
            'Camion' => 'Camión',
            'Otro'=>'Otro'
            // Agrega más tipos según lo necesites
        ];
    
        // Obtener las marcas y modelos para los selectores
        $marcas = Marca::all();
        $modelos = Modelo::all();
    
        // Retornar la vista de edición con los datos necesarios
        return view('catalogos.vehiculos.edit', compact('catalogoVehiculo', 'tipos', 'marcas', 'modelos'));
    }
    

    public function update(Request $request, $id)
    {
        // Muestra los datos recibidos
        //dd($request->all());
    
        // Encuentra el vehículo por ID
        $vehiculo = Vehiculo::findOrFail($id);
    
        // Validación condicional
        $validationRules = [];
    
        if ($request->has('tipo')) {
            $validationRules['tipo'] = 'string|max:255';
        }
    
        if ($request->has('relacion_marca_modelo_id')) {
            $validationRules['relacion_marca_modelo_id'] = 'exists:relacion_marca_modelo,id';
        }
    
        if ($request->has('color')) {
            $validationRules['color'] = 'string|max:50';
        }
    
        if ($request->has('placa')) {
            $validationRules['placa'] = 'string|max:10|unique:vehiculos,placa,'.$id;
        }
    
        if ($request->has('activo')) {
            $validationRules['activo'] = 'boolean';
        }
    
        // Valida los datos de entrada según las reglas construidas
        $request->validate($validationRules);
    
        // Actualiza solo los campos que fueron enviados en la solicitud
        if ($request->has('tipo')) {
            $vehiculo->tipo = $request->tipo;
        }
    
        if ($request->has('relacion_marca_modelo_id')) {
            $vehiculo->relacion_marca_modelo_id = $request->relacion_marca_modelo_id;
        }
    
        if ($request->has('color')) {
            $vehiculo->color = $request->color;
        }
    
        if ($request->has('placa')) {
            $vehiculo->placa = $request->placa;
        }
    
        if ($request->has('activo')) {
            $vehiculo->activo = $request->activo ? 1 : 0; // Convierte el checkbox a un valor booleano
        }
    
        // Guarda los cambios en la base de datos
        $vehiculo->save();
    
        // Redirecciona a donde necesites (por ejemplo, al índice de vehículos)
        return redirect()->route('modelos-vehiculos.index')->with('success', 'Vehículo actualizado correctamente.');
    }
    
    public function toggleActivo($id)
    {
        // Encuentra el vehículo por ID
        $vehiculo = Vehiculo::findOrFail($id);

        // Cambia el estado activo
        $vehiculo->activo = !$vehiculo->activo; // Cambia de 1 a 0 o viceversa

        // Guarda los cambios en la base de datos
        $vehiculo->save();

        // Devuelve una respuesta JSON
        return response()->json(['success' => true]);
    }

    

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();
        return redirect()->route('catalogo-vehiculos.index')->with('success', 'Vehículo eliminado con éxito.');
    }


    public function estado($id)
    {
        // Buscar la gasolinera por su ID
        $dato = Vehiculo::findOrFail($id);

        // Cambiar el campo activo

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-vehiculos.index')->with('success', 'El registro de Vehiculos ha sido activado.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-vehiculos.index')->with('success', 'El registro de Vehiculos ha sido eliminado.');
        }




    }
}
