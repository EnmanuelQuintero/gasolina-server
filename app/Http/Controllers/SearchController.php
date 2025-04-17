<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;

class SearchController extends Controller
{
    /**
     * Maneja la búsqueda en la tabla Orden.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Validar la entrada
        $validated = $request->validate([
            'query' => 'required|string|max:255',
        ]);

        // Buscar en la tabla Orden y en la columna token
        $ordenes = Orden::where('token', 'like', "%{$query}%")
                         ->get()
                         ->map(function($orden) {
                             return [
                                 'type' => 'Orden',
                                 'title' => "Orden #{$orden->id}",
                                 'url' => route('orden.show', $orden->id)
                             ];
                         });
    
        // Retornar resultados en formato JSON
        return response()->json(['results' => $ordenes]);
    }
}
