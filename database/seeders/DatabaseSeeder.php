<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(CreateUsersAndAssignRolesSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(CargoSeeder::class);
        $this->call(RelacionDepartamentoCargoSeeder::class);
        $this->call(ModeloSeeder::class);
        $this->call(RelacionMarcaModeloSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(CombustibleSeeder::class);
        $this->call(GasolineraSeeder::class);
        $this->call(VehiculoSeeder::class);
    }
}
