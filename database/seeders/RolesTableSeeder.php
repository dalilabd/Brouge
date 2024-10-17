<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si les rôles existent déjà avant de les créer
        if (!Role::where('name', 'superadmin')->exists()) {
            Role::create(['name' => 'superadmin']);
        }

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        if (!Role::where('name', 'user')->exists()) {
            Role::create(['name' => 'user']);
        }

        // Appeler le seeder des permissions après la création des rôles
        $this->call(PermissionsTableSeeder::class);
    }
}
