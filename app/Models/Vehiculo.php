<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    // Define la tabla asociada
    protected $table = 'vehiculos';


    protected $fillable = [
        'activo',
        'tipo',
        'relacion_marca_modelo_id',
        'color',
        'placa'
    ];


    

    public function marcaModelo()
    {
        return $this->belongsTo(RelacionMarcaModelo::class, 'relacion_marca_modelo_id');
    }

}
