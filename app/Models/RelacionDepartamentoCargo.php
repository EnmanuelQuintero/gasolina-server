<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionDepartamentoCargo extends Model
{
    use HasFactory;
    protected $table = 'relacion_departamento_cargo';

    protected $fillable = [
        'departamento_id',
        'cargo_id',

    ];
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
