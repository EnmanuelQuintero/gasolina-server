<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['nombre' => 'Toyota', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Honda', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Ford', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Chevrolet', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Nissan', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Volkswagen', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'BMW', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mercedes-Benz', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Audi', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Hyundai', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Kia', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mazda', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Subaru', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Lexus', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mitsubishi', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Volvo', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Land Rover', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Jaguar', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tesla', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Porsche', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
