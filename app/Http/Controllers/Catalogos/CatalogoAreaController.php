<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatalogoArea;
use App\Models\Departamento;

class CatalogoAreaController extends Controller
{
    public function index()
    {
        $ruta_editar = route('catalogo-areas.update', ['catalogo_area' => 'dummy']);
        $ruta_store = route('catalogo-areas.store');
        $datos = Departamento::all();
        $ruta_estado = route('catalogo-areas.estado', ['id' => 'dummy']);
        $ruta_crear = route('catalogo-areas.create');
        $ruta = route('catalogo-areas.edit', ['catalogo_area' => 'dummy']);
        $nombre_tabla = 'Departamentos';
        return view('vista_generica.tabla_index', compact('datos', 'ruta', 'nombre_tabla','ruta_crear','ruta_estado','ruta_editar','ruta_store'));
    }

    public function create()
    {
        $nombre = 'Departamento';
        $ruta_store = route('catalogo-areas.store');
        return view('vista_generica.vista_crear', compact('ruta_store','nombre'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Departamento::create($request->all());
        return redirect()->route('personas.index')->with('success', 'Área creada exitosamente.');
    }

    public function edit($id)
    {
        $ruta = route('catalogo-areas.update', ['catalogo_area' => 'dummy']);
        $dato = Departamento::findOrFail($id);
        return view('vista_generica.vista_edicion', compact('dato', 'ruta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $catalogoArea = Departamento::findOrFail($id);

        $catalogoArea->update($request->all());
        return redirect()->route('catalogo-areas.index')->with('success', 'Área actualizada exitosamente.');
    }

    public function estado($id)
    {
        // Buscar Combustible por su ID
        $dato = Departamento::findOrFail($id);

        // Cambiar el campo activo a 0

        if($dato->activo == 0)
        {
            $dato->activo = 1;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-areas.index')->with('success', 'El departamento ha sido activado.');
        }
        else
        {
            $dato->activo = 0;
            $dato->save();
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('catalogo-areas.index')->with('success', 'El departamento ha sido desactivado.');
        }




    }
}
