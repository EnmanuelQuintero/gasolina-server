<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';

    protected $fillable = [
        'activo',
        'nombre',
    ];

    public function personas()
    {
        return $this->hasMany(Persona::class, 'departamento_cargo_id');
    }

}
