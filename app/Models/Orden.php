<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'orden';

    protected $fillable = [
        'activo',
        'fecha',
        'gasolinera_id',
        'autorizado_id',
        'token',
        'observaciones',
    ];

    public function gasolinera()
    {
        return $this->belongsTo(Gasolinera::class);
    }


    public function autorizado()
    {
        return $this->belongsTo(Persona::class, 'autorizado_id');
    }
    
    public function relacionDetalles()
    {
        return $this->hasMany(RelacionOrdenDetalle::class, 'orden_id');
    }

    public function detalles()
    {
        return $this->belongsToMany(DetalleOrden::class, 'relacion_orden_detalle', 'orden_id', 'detalle_orden_id');
    }
    
    public function relaciones()
    {
        return $this->hasMany(RelacionOrdenDetalle::class, 'orden_id');
    }
    

}
