<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionMarcaModelo extends Model
{
    use HasFactory;

    protected $table = 'relacion_marca_modelo';

    protected $fillable = [
        'activo',
        'marca_id',
        'modelo_id',

    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }

}
