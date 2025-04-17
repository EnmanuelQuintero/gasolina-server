<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modelos')->insert([
            ['nombre' => 'Corolla', 'created_at' => now(), 'updated_at' => now()], // Toyota
            ['nombre' => 'Camry', 'created_at' => now(), 'updated_at' => now()], // Toyota
            ['nombre' => 'Civic', 'created_at' => now(), 'updated_at' => now()], // Honda
            ['nombre' => 'Accord', 'created_at' => now(), 'updated_at' => now()], // Honda
            ['nombre' => 'F-150', 'created_at' => now(), 'updated_at' => now()], // Ford
            ['nombre' => 'Mustang', 'created_at' => now(), 'updated_at' => now()], // Ford
            ['nombre' => 'Silverado', 'created_at' => now(), 'updated_at' => now()], // Chevrolet
            ['nombre' => 'Equinox', 'created_at' => now(), 'updated_at' => now()], // Chevrolet
            ['nombre' => 'Altima', 'created_at' => now(), 'updated_at' => now()], // Nissan
            ['nombre' => 'Rogue', 'created_at' => now(), 'updated_at' => now()], // Nissan
            ['nombre' => 'Golf', 'created_at' => now(), 'updated_at' => now()], // Volkswagen
            ['nombre' => 'Passat', 'created_at' => now(), 'updated_at' => now()], // Volkswagen
            ['nombre' => 'X5', 'created_at' => now(), 'updated_at' => now()], // BMW
            ['nombre' => '3 Series', 'created_at' => now(), 'updated_at' => now()], // BMW
            ['nombre' => 'C-Class', 'created_at' => now(), 'updated_at' => now()], // Mercedes-Benz
            ['nombre' => 'E-Class', 'created_at' => now(), 'updated_at' => now()], // Mercedes-Benz
            ['nombre' => 'A4', 'created_at' => now(), 'updated_at' => now()], // Audi
            ['nombre' => 'Q5', 'created_at' => now(), 'updated_at' => now()], // Audi
            ['nombre' => 'Sonata', 'created_at' => now(), 'updated_at' => now()], // Hyundai
            ['nombre' => 'Tucson', 'created_at' => now(), 'updated_at' => now()], // Hyundai
        ]);
    }
}
