<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('el comando crea un usuario administrador si no existe', function () {
    // Ejecutar el comando
    Artisan::call('make:admin testadmin@example.com --password=securepassword');

    // Verificar que el usuario fue creado
    $this->assertDatabaseHas('users', [
        'email' => 'testadmin@example.com',
    ]);

    // Verificar que el usuario tiene el rol de admin
    $admin = User::where('email', 'testadmin@example.com')->first();
    expect($admin->hasRole('admin'))->toBeTrue();
});

test('el comando no permite duplicar usuarios con el mismo correo', function () {
    // Crear usuario administrador manualmente
    User::factory()->create(['email' => 'testadmin@example.com']);

    // Ejecutar el comando
    $exitCode = Artisan::call('make:admin testadmin@example.com');

    // Verificar que el mensaje de error se muestra
    $output = Artisan::output();
    expect($output)->toContain('El usuario con este email ya existe.');

    // Verificar que el código de salida es 1 (error)
    expect($exitCode)->toBe(1);
});

test('el comando crea el rol admin si no existe', function () {
    // Asegurar que el rol no existe antes de ejecutar el comando
    expect(Role::where('name', 'admin')->exists())->toBeFalse();

    // Ejecutar el comando
    Artisan::call('make:admin testadmin@example.com');

    // Verificar que el rol fue creado
    expect(Role::where('name', 'admin')->exists())->toBeTrue();
});

test('el comando asigna permisos al rol de admin', function () {
    // Ejecutar el comando
    Artisan::call('make:admin testadmin@example.com');

    // Obtener el rol admin
    $adminRole = Role::where('name', 'admin')->first();

    // Verificar que tiene los permisos correctos
    expect($adminRole->hasPermissionTo('crear generos, posts y analisis'))->toBeTrue();
    expect($adminRole->hasPermissionTo('administrar usuarios'))->toBeTrue();
    expect($adminRole->hasPermissionTo('editar posts y analisis'))->toBeTrue();
    expect($adminRole->hasPermissionTo('eliminar posts y analisis'))->toBeTrue();

});

test('el comando usa la contraseña por defecto si no se proporciona', function () {
    // Ejecutar el comando sin especificar la contraseña
    Artisan::call('make:admin testadmin@example.com');

    // Obtener el usuario creado
    $admin = User::where('email', 'testadmin@example.com')->first();

    // Verificar que la contraseña por defecto se usó
    expect(password_verify('admin123', $admin->password))->toBeTrue();
});

