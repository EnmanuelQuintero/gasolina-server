<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = [
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 1, 'color' => 'Blanco', 'placa' => 'ABC-123'],
            ['tipo' => 'Camion', 'relacion_marca_modelo_id' => 2, 'color' => 'Negro', 'placa' => 'DEF-456'],
            ['tipo' => 'Moto', 'relacion_marca_modelo_id' => 3, 'color' => 'Gris', 'placa' => 'GHI-789'],
            ['tipo' => 'Camioneta', 'relacion_marca_modelo_id' => 4, 'color' => 'Plateado', 'placa' => 'JKL-012'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 5, 'color' => 'Azul', 'placa' => 'MNO-345'],
            ['tipo' => 'Camion', 'relacion_marca_modelo_id' => 6, 'color' => 'Rojo', 'placa' => 'PQR-678'],
            ['tipo' => 'Moto', 'relacion_marca_modelo_id' => 7, 'color' => 'Verde', 'placa' => 'STU-901'],
            ['tipo' => 'Camioneta', 'relacion_marca_modelo_id' => 8, 'color' => 'Morado', 'placa' => 'VWX-234'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 9, 'color' => 'Amarillo', 'placa' => 'YZA-567'],
            ['tipo' => 'Camion', 'relacion_marca_modelo_id' => 10, 'color' => 'Naranja', 'placa' => 'BCD-890'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 11, 'color' => 'Blanco', 'placa' => 'EFG-123'],
            ['tipo' => 'Camioneta', 'relacion_marca_modelo_id' => 12, 'color' => 'Negro', 'placa' => 'HIJ-456'],
            ['tipo' => 'Moto', 'relacion_marca_modelo_id' => 13, 'color' => 'Gris', 'placa' => 'KLM-789'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 14, 'color' => 'Plateado', 'placa' => 'NOP-012'],
            ['tipo' => 'Camion', 'relacion_marca_modelo_id' => 15, 'color' => 'Azul', 'placa' => 'QRS-345'],
            ['tipo' => 'Camioneta', 'relacion_marca_modelo_id' => 16, 'color' => 'Rojo', 'placa' => 'TUV-678'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 17, 'color' => 'Verde', 'placa' => 'WXY-901'],
            ['tipo' => 'Moto', 'relacion_marca_modelo_id' => 18, 'color' => 'Morado', 'placa' => 'ZAB-234'],
            ['tipo' => 'Camioneta', 'relacion_marca_modelo_id' => 19, 'color' => 'Amarillo', 'placa' => 'CDE-567'],
            ['tipo' => 'Sedan', 'relacion_marca_modelo_id' => 20, 'color' => 'Naranja', 'placa' => 'FGH-890'],
            ['tipo' => 'Camion', 'relacion_marca_modelo_id' => 20, 'color' => 'Blanco', 'placa' => 'IJK-123'],
        ];

        DB::table('vehiculos')->insert($vehiculos);
    }
}
