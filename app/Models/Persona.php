<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'activo',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'departamento_cargo_id',

    ];

    public function departamentoCargo()
    {
        return $this->belongsTo(RelacionDepartamentoCargo::class, 'departamento_cargo_id');
    }

}
