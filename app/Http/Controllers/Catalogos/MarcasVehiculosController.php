<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;

class MarcasVehiculosController extends Controller
{
    public function index()
    {
        $datos = Marca::all();
        $ruta_store = route('marcas-vehiculos.store');
        $ruta_estado = route('marcas-vehiculos.estado', ['id' => 'dummy']);
        $ruta_editar = route('marcas-vehiculos.update', ['marcas_vehiculo' => 'dummy']);
        $ruta_crear = route('marcas-vehiculos.create');
        $ruta = route('marcas-vehiculos.edit', ['marcas_vehiculo' => 'dummy']);
        $nombre_tabla='Marcas de Vehiculos';
        return view('vista_generica.tabla_index', compact('datos','ruta','nombre_tabla','ruta_crear', 'ruta_estado','ruta_store','ruta_editar'));
    }

    public function create()
    {
        $nombre = 'Marca de Vehiculo';
        $ruta_store = route('marcas-vehiculos.store');
        return view('vista_generica.vista_crear',compact('nombre','ruta_store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Marca::create($request->all());
        return redirect()->route('modelos-vehiculos.index')->with('success', 'Marca de vehículo creada exitosamente.');
    }

    public function edit($id)
    {
        $ruta = route('marcas-vehiculos.update', ['marcas_vehiculo' => 'dummy']);
        $dato = Marca::findOrFail($id);
        return view('vista_generica.vista_edicion', compact('dato','ruta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $marcaVehiculo = Marca::findOrFail($id);
        $marcaVehiculo->update($request->all());
        return redirect()->route('marcas-vehiculos.index')->with('success', 'Marca de vehículo actualizada exitosamente.');
    }

    public function estado($id)
    {
        // Buscar la gasolinera por su ID
        $dato = Marca::findOrFail($id);

        // Cambiar el campo activo

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('marcas-vehiculos.index')->with('success', 'La Marca del vehiculo ha sido activada.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('marcas-vehiculos.index')->with('success', 'La Marca del vehiculo ha sido desactivada.');
        }




    }
}
