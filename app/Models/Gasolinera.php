<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasolinera extends Model
{
    use HasFactory;

    protected $table = 'gasolineras';

    protected $fillable = [
        'activo',
        'nombre',
        'direccion',
    ];
}
