<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;

class GraficosController extends Controller
{
    public function getDataByDateRange(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
    
        // Suponiendo que estás filtrando por el campo 'created_at'
        $data = Marca::whereBetween('created_at', [$startDate, $endDate])->get();
    
        return response()->json($data);
    }
}
