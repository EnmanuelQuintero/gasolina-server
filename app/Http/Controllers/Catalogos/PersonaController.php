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

        //dd($request);
        // Forzar que los checkboxes existan aunque no estén marcados
        $request->merge([
            'autorizado' => $request->has('autorizado'),
            'chofer' => $request->has('chofer'),
        ]);

        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'departamento_cargo_id' => 'required|exists:relacion_departamento_cargo,id',
            'cedula' => 'nullable|string|max:20',
            'autorizado' => 'nullable|boolean',
            'chofer' => 'nullable|boolean',
        ]);
    
        // Verificar si ya existe una persona con la misma cédula (si se proporcionó)
        if ($request->filled('cedula')) {
            $existeCedula = Persona::where('cedula', $request->cedula)->exists();
            if ($existeCedula) {
                return back()->withErrors(['cedula' => 'Ya existe una persona registrada con esta cédula.'])->withInput();
            }
        }
    
        // Verificar si ya existe una persona con los mismos nombres y apellidos
        $existeNombre = Persona::where('primer_nombre', $request->primer_nombre)
            ->where('segundo_nombre', $request->segundo_nombre)
            ->where('primer_apellido', $request->primer_apellido)
            ->where('segundo_apellido', $request->segundo_apellido)
            ->exists();
    
        if ($existeNombre) {
            return back()->withErrors(['primer_nombre' => 'Ya existe una persona registrada con los mismos nombres y apellidos.'])->withInput();
        }
    
        Persona::create([
            'primer_nombre' => $request->primer_nombre,
            'segundo_nombre' => $request->segundo_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'departamento_cargo_id' => $request->departamento_cargo_id,
            'cedula' => $request->cedula,
            'autorizado' => $request->boolean('autorizado'),
            'chofer' => $request->boolean('chofer'),
        ]);
    
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
        // Forzar que los checkboxes existan aunque no estén marcados
        $request->merge([
            'autorizado' => $request->has('autorizado'),
            'chofer' => $request->has('chofer'),
        ]);
        
        $request->validate([
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'departamento_cargo_id' => 'required|exists:relacion_departamento_cargo,id',
            'cedula' => 'nullable|string|max:20',
            'autorizado' => 'nullable|boolean',
            'chofer' => 'nullable|boolean',
        ]);
    
        $persona = Persona::findOrFail($id);
    
        // Validar duplicado por cédula (si se proporcionó y no pertenece a este mismo registro)
        if ($request->filled('cedula')) {
            $existeCedula = Persona::where('cedula', $request->cedula)
                ->where('id', '!=', $id)
                ->exists();
    
            if ($existeCedula) {
                return back()->withErrors(['cedula' => 'Ya existe una persona registrada con esta cédula.'])->withInput();
            }
        }
    
        // Validar duplicado por nombres y apellidos
        $existeNombre = Persona::where('primer_nombre', $request->primer_nombre)
            ->where('segundo_nombre', $request->segundo_nombre)
            ->where('primer_apellido', $request->primer_apellido)
            ->where('segundo_apellido', $request->segundo_apellido)
            ->where('id', '!=', $id)
            ->exists();
    
        if ($existeNombre) {
            return back()->withErrors(['primer_nombre' => 'Ya existe una persona con los mismos nombres y apellidos.'])->withInput();
        }
    
        $persona->update([
            'primer_nombre' => $request->primer_nombre,
            'segundo_nombre' => $request->segundo_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'departamento_cargo_id' => $request->departamento_cargo_id,
            'cedula' => $request->cedula,
            'autorizado' => $request->boolean('autorizado'),
            'chofer' => $request->boolean('chofer'),
        ]);
    
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
