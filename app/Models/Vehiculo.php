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
        'placa',
        'estado' // <- Agregado aquí
    ];

    /**
     * Relación con la tabla relacion_marca_modelo
     */
    public function marcaModelo()
    {
        return $this->belongsTo(RelacionMarcaModelo::class, 'relacion_marca_modelo_id');
    }

    /**
     * Constantes de estados posibles
     */
    public const ESTADO_OPERATIVO = 'operativo';
    public const ESTADO_TALLER = 'taller';
    public const ESTADO_BAJA = 'baja';

    /**
     * Devuelve los estados posibles
     */
    public static function estados(): array
    {
        return [
            self::ESTADO_OPERATIVO,
            self::ESTADO_TALLER,
            self::ESTADO_BAJA,
        ];
    }
}
