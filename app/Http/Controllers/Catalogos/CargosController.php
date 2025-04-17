<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\RelacionDepartamentoCargo;

class CargosController extends Controller
{
        // Mostrar la lista de cargos
        public function index()
        {
            $ruta_editar = route('cargos.update', ['cargo' => 'dummy']);
            $ruta_store = route('cargos.store');
            $datos = Cargo::all();
            // Usa 'catalogo_area' en lugar de 'catalogo_areas'
            $ruta_estado = route('cargos.estado', ['id' => 'dummy']);
            $ruta_crear= route('cargos.create');
            $ruta = route('cargos.edit', ['cargo' => 'dummy']);
            $nombre_tabla = 'Cargos';
            return view('vista_generica.tabla_index', compact('datos', 'ruta', 'nombre_tabla','ruta_crear','ruta_estado','ruta_store','ruta_editar'));
        }
    
        // Mostrar el formulario para crear un nuevo cargo
        public function create()
        {
            $nombre = 'cargo';
            $ruta_store = route('cargos.store');
            return view('vista_generica.vista_crear',compact('nombre','ruta_store'));
        }
    
        // Almacenar un nuevo cargo en la base de datos
        public function store(Request $request)
        {
            $request->validate([
                'cargo' => 'required|string|max:255',
                'departamento_id' => 'required|exists:departamentos,id',
            ]);

            $cargo = Cargo::create(
                [
                    'nombre' =>$request->cargo,
                ]
            );

            RelacionDepartamentoCargo::create(
                [
                    'departamento_id' => $request->departamento_id,
                    'cargo_id' => $cargo->id,
                    'activo' => 1,
                ]
                );
    
            return redirect()->route('personas.index')->with('success', 'Cargo creado exitosamente.');
        }
    
        // Mostrar el formulario para editar un cargo existente
        public function edit($id)
        {
            $ruta = route('cargos.update', ['cargo' => 'dummy']);
            $dato = Cargo::findOrFail($id);
            return view('vista_generica.vista_edicion', compact('dato','ruta'));
        }
    
        // Actualizar un cargo en la base de datos
        public function update(Request $request, $id)
        {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $cargo = Cargo::findOrFail($id);
            $cargo->update($request->all());
    
            return redirect()->route('cargos.index')->with('success', 'Cargo actualizado exitosamente.');
        }
    
        // Eliminar un cargo de la base de datos
        public function estado($id)
        {
            // Buscar Combustible por su ID
            $dato = Cargo::findOrFail($id);
    
            // Cambiar el campo activo a 0
    
            if($dato->activo == 0)
            {
                $dato->activo = 1;
                $dato->save();
                // Redirigir de vuelta con un mensaje de éxito
                return redirect()->route('cargos.index')->with('success', 'El cargo ha sido activado.');
            }
            else
            {
                $dato->activo = 0;
                $dato->save();
                // Redirigir de vuelta con un mensaje de éxito
                return redirect()->route('cargos.index')->with('success', 'El cargo ha sido desactivado.');
            }
    
    
    
    
        }
}
