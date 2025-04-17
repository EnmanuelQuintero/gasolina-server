<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gasolinera;

class CatalogoGasolinerasController extends Controller
{
    public function index()
    {
        $ruta_editar = route('catalogo-gasolineras.update', ['catalogo_gasolinera' => 'dummy']);
        $ruta_store = route('catalogo-gasolineras.store');
        $ruta_estado = route('catalogo-gasolineras.estado', ['id' => 'dummy']);
        $ruta_crear = route('catalogo-gasolineras.create');
        $datos = Gasolinera::all();
        $ruta = route('catalogo-gasolineras.edit', ['catalogo_gasolinera' => 'dummy']);
        $nombre_tabla = 'Gasolineras';
        return view('vista_generica.tabla_index', compact('datos', 'ruta', 'nombre_tabla','ruta_crear','ruta_estado','ruta_store','ruta_editar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        Gasolinera::create($request->all());
        return redirect()->route('catalogo-gasolineras.index')->with('success', 'Gasolinera creada exitosamente.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            
        ]);
        $catalogoGasolinera = Gasolinera::findOrFail($id);
        $catalogoGasolinera->update($request->all());
        return redirect()->route('catalogo-gasolineras.index')->with('success', 'Gasolinera actualizada exitosamente.');
    }

    public function estado($id)
    {
        // Buscar la gasolinera por su ID
        $dato = Gasolinera::findOrFail($id);

        // Cambiar el campo activo

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-gasolineras.index')->with('success', 'El registro de la gasolinera ha sido activada.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-gasolineras.index')->with('success', 'El registro de la gasolinera ha sido desactivada.');
        }




    }


}
