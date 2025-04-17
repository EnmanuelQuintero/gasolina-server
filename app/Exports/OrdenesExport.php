<?php

namespace App\Exports;

use App\Models\Orden;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Entregado;
use App\Models\RelacionOrdenDetalle;
class OrdenesExport implements FromView
{
    protected $ordenes;
    protected $entregadas;
    protected $relaciones;
    protected $startDate;
    protected $endDate;

    public function __construct($ordenes, $entregadas, $relaciones, $startDate, $endDate)
    {
        $this->ordenes = $ordenes;
        $this->entregadas = $entregadas;
        $this->relaciones = $relaciones;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('reporte.excel.excel', [
            'ordenes' => $this->ordenes,
            'entregadas' => $this->entregadas,
            'relaciones' => $this->relaciones,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}