<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelacionDepartamentoCargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $relaciones = [
            ['departamento_id' => 1, 'cargo_id' => 1], // Administracion - Gerente General
            ['departamento_id' => 1, 'cargo_id' => 2], // Administracion - Subgerente
            ['departamento_id' => 2, 'cargo_id' => 6], // Informatica - Ingeniero de Software
            ['departamento_id' => 2, 'cargo_id' => 7], // Informatica - Desarrollador Backend
            ['departamento_id' => 2, 'cargo_id' => 8], // Informatica - Desarrollador Frontend
            ['departamento_id' => 3, 'cargo_id' => 3], // Recursos Humanos - Jefe de Recursos Humanos
            ['departamento_id' => 3, 'cargo_id' => 12], // Recursos Humanos - Ejecutivo de Ventas
            ['departamento_id' => 4, 'cargo_id' => 4], // Contabilidad - Contador
            ['departamento_id' => 4, 'cargo_id' => 5], // Contabilidad - Analista Financiero
            ['departamento_id' => 5, 'cargo_id' => 16], // Marketing - Jefe de Marketing
            ['departamento_id' => 5, 'cargo_id' => 17], // Marketing - Especialista en Marketing Digital
            ['departamento_id' => 5, 'cargo_id' => 18], // Marketing - Community Manager
        ];

        DB::table('relacion_departamento_cargo')->insert($relaciones);
    }
}
