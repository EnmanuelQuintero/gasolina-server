<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['nombre' => 'Gerente General', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Subgerente', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jefe de Recursos Humanos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Contador', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Analista Financiero', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ingeniero de Software', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Desarrollador Backend', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Desarrollador Frontend', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Administrador de Bases de Datos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Técnico en Redes', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jefe de Ventas', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ejecutivo de Ventas', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Coordinador de Proyectos', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jefe de Operaciones', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Supervisor de Producción', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jefe de Marketing', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Especialista en Marketing Digital', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Community Manager', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jefe de Logística', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Coordinador de Compras', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
