<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CombustibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $combustibles = [
            ['nombre' => 'Gasolina Regular'],
            ['nombre' => 'Gasolina Premium'],
            ['nombre' => 'Diésel'],
            ['nombre' => 'GNL (Gas Natural Licuado)'],
            ['nombre' => 'GPL (Gas Licuado de Petróleo)'],
            ['nombre' => 'Biodiésel'],
            ['nombre' => 'Etanol'],
            ['nombre' => 'Gasóleo'],
            ['nombre' => 'Queroseno'],
            ['nombre' => 'Biogás'],
            ['nombre' => 'Electricidad'], // Para vehículos eléctricos
            ['nombre' => 'Hidrógeno'],
            ['nombre' => 'Gas Natural Comprimido (GNC)'],
            ['nombre' => 'Gasolinas Sintéticas'],
            ['nombre' => 'Aceite Vegetal'],
            ['nombre' => 'Combustible de aviación (Jet Fuel)'],
            ['nombre' => 'Fuel Oil'],
            ['nombre' => 'Propano'],
            ['nombre' => 'Gas de Síntesis'],
            ['nombre' => 'Gasóleo de calefacción'],
            ['nombre' => 'Combustibles de segunda generación'], // Combustibles producidos de materiales no alimentarios
        ];

        DB::table('combustibles')->insert($combustibles);
    }
}
