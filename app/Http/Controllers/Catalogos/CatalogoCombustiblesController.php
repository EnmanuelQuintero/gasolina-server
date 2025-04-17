<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Combustible;

class CatalogoCombustiblesController extends Controller
{
    // Mostrar la lista de combustibles
    public function index()
    {
        $ruta_editar = route('catalogo-combustibles.update', ['catalogo_combustible' => 'dummy']);
        $ruta_store = route('catalogo-combustibles.store');
        $ruta_estado = route('catalogo-combustibles.estado', ['id' => 'dummy']);
        $ruta_crear = route('catalogo-combustibles.create');
        $datos = Combustible::all();
        $ruta = route('catalogo-combustibles.edit', ['catalogo_combustible' => 'dummy']);
        $nombre_tabla = 'Tipos de Combustible';
        return view('vista_generica.tabla_index', compact('datos', 'ruta', 'nombre_tabla','ruta_crear','ruta_estado','ruta_editar','ruta_store'));
    }
    

    
        // Almacenar un nuevo combustible en la base de datos
        public function store(Request $request)
        {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
    
            Combustible::create($request->all());
    
            return redirect()->route('catalogo-combustibles.index')->with('success', 'Combustible creado exitosamente.');
        }
        // Actualizar un combustible en la base de datos
        public function update(Request $request, $id)
        {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);


            $catalogoCombustible= Combustible::findOrFail($id);
            $catalogoCombustible->update($request->all());
    
            return redirect()->route('catalogo-combustibles.index')->with('success', 'Combustible actualizado exitosamente.');
        }
    
        public function estado($id)
        {
            // Buscar Combustible por su ID
            $dato = Combustible::findOrFail($id);
    
            // Cambiar el campo activo a 0
    
            if($dato->activo == 0)
            {
                $dato->activo = 1;
                $dato->save();
                // Redirigir de vuelta con un mensaje de éxito
                return redirect()->route('catalogo-combustibles.index')->with('success', 'El registro de combustible ha sido activado.');
            }
            else
            {
                $dato->activo = 0;
                $dato->save();
                // Redirigir de vuelta con un mensaje de éxito
                return redirect()->route('catalogo-combustibles.index')->with('success', 'El registro de combustible ha sido desactivado.');
            }
    
    
    
    
        }
}
