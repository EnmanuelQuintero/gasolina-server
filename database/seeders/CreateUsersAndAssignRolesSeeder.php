<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class CreateUsersAndAssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener roles existentes

        $adminRole = Role::where('name', 'admin')->first();
        $operadorRole = Role::where('name', 'operador')->first();


        // Verificar si los roles existen
        if ( !$adminRole || !$operadorRole) {
            $this->command->error('Algunos roles no existen en la base de datos.');
            return;
        }

        // Crear usuarios y asignar roles

        $userAdmin = User::updateOrCreate(
            ['usuario' => 'admin'],
            ['password' => bcrypt('password123')]
        );
        $userAdmin->assignRole($adminRole);

        $userOperador = User::updateOrCreate(
            ['usuario' => 'operador'],
            ['password' => bcrypt('password123')]
        );
        $userOperador->assignRole($operadorRole);

    }
}
