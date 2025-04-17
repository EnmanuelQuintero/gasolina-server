<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personas = [
            ['primer_nombre' => 'Juan', 'segundo_nombre' => 'Carlos', 'primer_apellido' => 'García', 'segundo_apellido' => 'López', 'departamento_cargo_id' => 1],
            ['primer_nombre' => 'Ana', 'segundo_nombre' => 'María', 'primer_apellido' => 'Martínez', 'segundo_apellido' => 'Pérez', 'departamento_cargo_id' => 2],
            ['primer_nombre' => 'Luis', 'segundo_nombre' => 'Fernando', 'primer_apellido' => 'Ramírez', 'segundo_apellido' => 'Hernández', 'departamento_cargo_id' => 3],
            ['primer_nombre' => 'Sofía', 'segundo_nombre' => 'Elena', 'primer_apellido' => 'Torres', 'segundo_apellido' => 'Mendoza', 'departamento_cargo_id' => 4],
            ['primer_nombre' => 'Pedro', 'segundo_nombre' => 'Alejandro', 'primer_apellido' => 'Sánchez', 'segundo_apellido' => 'Díaz', 'departamento_cargo_id' => 5],
            ['primer_nombre' => 'Laura', 'segundo_nombre' => 'Isabel', 'primer_apellido' => 'González', 'segundo_apellido' => 'Jiménez', 'departamento_cargo_id' => 6],
            ['primer_nombre' => 'Javier', 'segundo_nombre' => 'Antonio', 'primer_apellido' => 'Morales', 'segundo_apellido' => 'Vásquez', 'departamento_cargo_id' => 7],
            ['primer_nombre' => 'Gabriela', 'segundo_nombre' => 'Estefanía', 'primer_apellido' => 'Márquez', 'segundo_apellido' => 'Reyes', 'departamento_cargo_id' => 8],
            ['primer_nombre' => 'Diego', 'segundo_nombre' => 'Armando', 'primer_apellido' => 'Hernández', 'segundo_apellido' => 'Pérez', 'departamento_cargo_id' => 9],
            ['primer_nombre' => 'Valentina', 'segundo_nombre' => 'Noelia', 'primer_apellido' => 'Salazar', 'segundo_apellido' => 'Cruz', 'departamento_cargo_id' => 10],
            ['primer_nombre' => 'Andrés', 'segundo_nombre' => 'Alejandro', 'primer_apellido' => 'Vega', 'segundo_apellido' => 'García', 'departamento_cargo_id' => 11],
            ['primer_nombre' => 'Camila', 'segundo_nombre' => 'Renata', 'primer_apellido' => 'Cordero', 'segundo_apellido' => 'Rivas', 'departamento_cargo_id' => 12],
            ['primer_nombre' => 'Fernando', 'segundo_nombre' => 'José', 'primer_apellido' => 'Alvarado', 'segundo_apellido' => 'Salas', 'departamento_cargo_id' => 1],
            ['primer_nombre' => 'Patricia', 'segundo_nombre' => 'Cristina', 'primer_apellido' => 'Pérez', 'segundo_apellido' => 'Acosta', 'departamento_cargo_id' => 2],
            ['primer_nombre' => 'Ricardo', 'segundo_nombre' => 'Eduardo', 'primer_apellido' => 'Moreno', 'segundo_apellido' => 'Soto', 'departamento_cargo_id' => 3],
            ['primer_nombre' => 'Isabel', 'segundo_nombre' => 'Lucía', 'primer_apellido' => 'Mora', 'segundo_apellido' => 'Navarro', 'departamento_cargo_id' => 4],
            ['primer_nombre' => 'Hugo', 'segundo_nombre' => 'Manuel', 'primer_apellido' => 'López', 'segundo_apellido' => 'Vega', 'departamento_cargo_id' => 5],
            ['primer_nombre' => 'Mariana', 'segundo_nombre' => 'Diana', 'primer_apellido' => 'Cruz', 'segundo_apellido' => 'Mena', 'departamento_cargo_id' => 6],
            ['primer_nombre' => 'Ernesto', 'segundo_nombre' => 'Félix', 'primer_apellido' => 'Salas', 'segundo_apellido' => 'Téllez', 'departamento_cargo_id' => 7],
            ['primer_nombre' => 'Marta', 'segundo_nombre' => 'Gabriela', 'primer_apellido' => 'Bermúdez', 'segundo_apellido' => 'Ortega', 'departamento_cargo_id' => 8],
            ['primer_nombre' => 'Sergio', 'segundo_nombre' => 'Adrián', 'primer_apellido' => 'Chávez', 'segundo_apellido' => 'Serrano', 'departamento_cargo_id' => 9],
            ['primer_nombre' => 'Patricia', 'segundo_nombre' => 'Alba', 'primer_apellido' => 'Guerrero', 'segundo_apellido' => 'López', 'departamento_cargo_id' => 10],
        ];

        DB::table('personas')->insert($personas);
    }
}
