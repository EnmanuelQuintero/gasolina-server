<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden';

    protected $fillable = [
        'activo',
        'vehiculo_id',
        'chofer_id',
        'combustible_id',
        'cantidad',
        'medida',
        'kilometros'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function chofer()
    {
        return $this->belongsTo(Persona::class, 'chofer_id');
    }

    public function combustible()
    {
        return $this->belongsTo(Combustible::class);
    }

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'relacion_orden_detalle', 'detalle_orden_id', 'orden_id');
    }


}
