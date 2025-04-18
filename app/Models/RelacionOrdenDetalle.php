<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RelacionOrdenDetalle extends Model
{
    use HasFactory;

    protected $table = 'relacion_orden_detalle';

    protected $fillable = [
        'activo',
        'entregado',
        'fecha_entrega',
        'orden_id',
        'detalle_orden_id',
    ];

    protected $casts = [
        'entregado' => 'boolean',       
        'activo' => 'boolean',
        'fecha_entrega' => 'date',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function detalleOrden()
    {
        return $this->belongsTo(DetalleOrden::class, 'detalle_orden_id');
    }
    
}