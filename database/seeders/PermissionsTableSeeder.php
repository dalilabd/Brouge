<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Création des permissions si elles n'existent pas déjà
        $permissions = [
            'add users',
            'delete users',
            'edit users',
            'read users',
            'add admins',
            'manage roles',
            'manage permissions'
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Attribution des permissions aux rôles
        $superAdmin = Role::findByName('superadmin');
        $admin = Role::findByName('admin');
        $user = Role::findByName('user');

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'add users',
            'delete users',
            'edit users',
            'read users'
        ]);

        $user->givePermissionTo('read users');
    }
}
