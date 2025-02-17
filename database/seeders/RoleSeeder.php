<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear Roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'redactor']);
        Role::firstOrCreate(['name' => 'lector']);

        // Crear Permisos
        Permission::firstOrCreate(['name' => 'crear generos']);
        Permission::firstOrCreate(['name' => 'administrar usuarios']);
        Permission::firstOrCreate(['name' => 'crear posts']);
        Permission::firstOrCreate(['name' => 'crear analisis']);
        Permission::firstOrCreate(['name' => 'leer post']);

        // Asignar permisos a roles
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(['crear generos', 'administrar usuarios']);

        $redactor = Role::where('name', 'redactor')->first();
        $redactor->givePermissionTo(['crear posts', 'crear analisis']);

        $lector = Role::where('name', 'lector')->first();
        $lector->givePermissionTo(['leer post']);
    }
}
