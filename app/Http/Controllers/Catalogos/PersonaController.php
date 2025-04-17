<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\RelacionDepartamentoCargo;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $departamentos = Departamento::all();
        $departamentosCargos = RelacionDepartamentoCargo::all();
        $personas = Persona::all();
        //dd($departamentosCargos);
        return view('persona.index', compact('departamentos', 'departamentosCargos', 'personas'));
    }
    
    
    

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|string|max:255',
            'departamento_cargo_id' => 'required|exists:relacion_departamento_cargo,id',
        ]);

        Persona::create($request->all());

        return redirect()->route('personas.index')->with('success', 'Persona creada con éxito.');
    }
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        return redirect()->route('personas.index', compact('persona'));
    }

    // Método para actualizar una persona
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'departamento_cargo_id' => 'required|exists:relacion_departamento_cargo,id',
        ]);
    
        // Encuentra la persona y actualiza
        $persona = Persona::findOrFail($id);
        $persona->update($request->all());
    
        // Redireccionar después de la actualización
        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente.');
    }
    


    public function toggleActivo($id)
    {
        //dd($id);
        // Encuentra el vehículo por ID
        $persona = Persona::findOrFail($id);

        // Cambia el estado activo
        $persona->activo = !$persona->activo; // Cambia de 1 a 0 o viceversa

        // Guarda los cambios en la base de datos
        $persona->save();

        // Devuelve una respuesta JSON
        return response()->json(['success' => true]);
    }
}
