<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GasolineraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gasolineras = [
            ['nombre' => 'Petrobras', 'direccion' => 'Carretera a Chichigalpa, León'],
            ['nombre' => 'Esso', 'direccion' => 'Calle El Mercadito, León'],
            ['nombre' => 'Puma Energy', 'direccion' => 'Calle al Volcán, León'],
            ['nombre' => 'Texaco', 'direccion' => 'Calle de la Independencia, León'],
            ['nombre' => 'Gasolinera Uno', 'direccion' => 'Carretera León - Managua, León'],
            ['nombre' => 'La Gran Gasolinera', 'direccion' => 'Carretera hacia el Aeropuerto, León'],
            ['nombre' => 'Gasolineras Centroamérica', 'direccion' => 'Frente a la UNAN, León'],
            ['nombre' => 'Gasolinera La Paz', 'direccion' => 'Kilómetro 55, León'],
            ['nombre' => 'Gasolineras La Estrella', 'direccion' => 'Calle 15 de Septiembre, León'],
            ['nombre' => 'Gasolinera San Francisco', 'direccion' => 'Avenida Rubén Darío, León'],
            ['nombre' => 'Gasolinera Villa Rica', 'direccion' => 'Carretera a La Paz Centro, León'],
            ['nombre' => 'Gasolinera La Virgen', 'direccion' => 'Calle del Comercio, León'],
            ['nombre' => 'Gasolinera La Isla', 'direccion' => 'Avenida Juan Pablo II, León'],
            ['nombre' => 'Gasolinera El Pueblo', 'direccion' => 'Barrio San Juan, León'],
            ['nombre' => 'Gasolinera Santa Fe', 'direccion' => 'Carretera León - Chichigalpa, León'],
            ['nombre' => 'Gasolinera Nueva Vida', 'direccion' => 'Carretera a León Viejo, León'],
            ['nombre' => 'Gasolinera El Semáforo', 'direccion' => 'Intersección Avenida Bolívar, León'],
            ['nombre' => 'Gasolinera El Faro', 'direccion' => 'Carretera al Volcán Cerro Negro, León'],
            ['nombre' => 'Gasolinera San Martín', 'direccion' => 'Frente a la Plaza de León, León'],
            ['nombre' => 'Gasolinera El Tigre', 'direccion' => 'Barrio La Merced, León'],
            ['nombre' => 'Gasolinera La Ciudadela', 'direccion' => 'Carretera a Telica, León'],
        ];

        DB::table('gasolineras')->insert($gasolineras);
    }
}
