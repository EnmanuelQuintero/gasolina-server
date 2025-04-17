<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelacionMarcaModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('relacion_marca_modelo')->insert([
            ['marca_id' => 1, 'modelo_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Toyota - Corolla
            ['marca_id' => 1, 'modelo_id' => 2, 'created_at' => now(), 'updated_at' => now()], // Toyota - Camry
            ['marca_id' => 2, 'modelo_id' => 3, 'created_at' => now(), 'updated_at' => now()], // Honda - Civic
            ['marca_id' => 2, 'modelo_id' => 4, 'created_at' => now(), 'updated_at' => now()], // Honda - Accord
            ['marca_id' => 3, 'modelo_id' => 5, 'created_at' => now(), 'updated_at' => now()], // Ford - F-150
            ['marca_id' => 3, 'modelo_id' => 6, 'created_at' => now(), 'updated_at' => now()], // Ford - Mustang
            ['marca_id' => 4, 'modelo_id' => 7, 'created_at' => now(), 'updated_at' => now()], // Chevrolet - Silverado
            ['marca_id' => 4, 'modelo_id' => 8, 'created_at' => now(), 'updated_at' => now()], // Chevrolet - Equinox
            ['marca_id' => 5, 'modelo_id' => 9, 'created_at' => now(), 'updated_at' => now()], // Nissan - Altima
            ['marca_id' => 5, 'modelo_id' => 10, 'created_at' => now(), 'updated_at' => now()], // Nissan - Rogue
            ['marca_id' => 6, 'modelo_id' => 11, 'created_at' => now(), 'updated_at' => now()], // Volkswagen - Golf
            ['marca_id' => 6, 'modelo_id' => 12, 'created_at' => now(), 'updated_at' => now()], // Volkswagen - Passat
            ['marca_id' => 7, 'modelo_id' => 13, 'created_at' => now(), 'updated_at' => now()], // BMW - X5
            ['marca_id' => 7, 'modelo_id' => 14, 'created_at' => now(), 'updated_at' => now()], // BMW - 3 Series
            ['marca_id' => 8, 'modelo_id' => 15, 'created_at' => now(), 'updated_at' => now()], // Mercedes-Benz - C-Class
            ['marca_id' => 8, 'modelo_id' => 16, 'created_at' => now(), 'updated_at' => now()], // Mercedes-Benz - E-Class
            ['marca_id' => 9, 'modelo_id' => 17, 'created_at' => now(), 'updated_at' => now()], // Audi - A4
            ['marca_id' => 9, 'modelo_id' => 18, 'created_at' => now(), 'updated_at' => now()], // Audi - Q5
            ['marca_id' => 10, 'modelo_id' => 19, 'created_at' => now(), 'updated_at' => now()], // Hyundai - Sonata
            ['marca_id' => 10, 'modelo_id' => 20, 'created_at' => now(), 'updated_at' => now()], // Hyundai - Tucson
        ]);
    }
}
