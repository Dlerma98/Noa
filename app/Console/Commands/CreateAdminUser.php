<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador con permisos predefinidos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->option('password') ?? 'admin123';

        // Verificar si el usuario ya existe
        if (User::where('email', $email)->exists()) {
            $this->error('El usuario con este email ya existe.');
            return 1;
        }

        // Crear el rol de administrador si no existe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear los permisos
        Permission::firstOrCreate(['name' => 'crear generos']);
        Permission::firstOrCreate(['name' => 'administrar usuarios']);

        // Asignar permisos al rol de admin
        $adminRole->givePermissionTo(['crear generos', 'administrar usuarios']);

        // Crear el usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => $email,
            'birthdate'=>"2000-01-01",
            'password' => bcrypt($password),
        ]);

        // Asignar el rol de administrador al usuario
        $admin->assignRole('admin');

        $this->info("Usuario administrador creado con éxito.");
        return 0;
    }
}
