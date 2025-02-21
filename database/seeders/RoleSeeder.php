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
        Role::firstOrCreate(['name' => 'redactor']);
        Role::firstOrCreate(['name' => 'lector']);

        // Crear Permisos
        Permission::firstOrCreate(['name' => 'crear posts']);
        Permission::firstOrCreate(['name' => 'crear analisis']);
        Permission::firstOrCreate(['name' => 'leer post']);

        // Asignar permisos a roles
        $redactor = Role::where('name', 'redactor')->first();
        $redactor->givePermissionTo(['crear posts', 'crear analisis']);

        $lector = Role::where('name', 'lector')->first();
        $lector->givePermissionTo(['leer post']);
    }
}
