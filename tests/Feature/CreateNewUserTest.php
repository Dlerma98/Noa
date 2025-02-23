<?php

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear los roles antes de usarlos
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector', 'guard_name' => 'web']);
});

test('un usuario puede registrarse con datos válidos', function () {
    $action = new CreateNewUser();

    $user = $action->create([
        'name' => 'Juan Pérez',
        'email' => 'juan@example.com',
        'birthdate' => Carbon::now()->subYears(18)->format('Y-m-d'), // Usuario mayor de 16 años
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);
    $user->assignRole('lector');

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Juan Pérez');
    expect($user->email)->toBe('juan@example.com');
});

test('no se puede registrar un usuario menor de 16 años', function () {
    $this->expectException(ValidationException::class);

    $action = new CreateNewUser();
    $action->create([
        'name' => 'Pedro Martínez',
        'email' => 'pedro@example.com',
        'birthdate' => Carbon::now()->subYears(15)->format('Y-m-d'), // Menor de 16 años
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);
});

test('el correo electrónico debe ser único', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $this->expectException(ValidationException::class);

    $action = new CreateNewUser();
    $action->create([
        'name' => 'Usuario Duplicado',
        'email' => 'test@example.com', // Correo ya registrado
        'birthdate' => Carbon::now()->subYears(18)->format('Y-m-d'),
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);
});

test('la contraseña debe tener al menos 8', function () {
    $this->expectException(ValidationException::class);

    $action = new CreateNewUser();
    $action->create([
        'name' => 'María López',
        'email' => 'maria@example.com',
        'birthdate' => Carbon::now()->subYears(18)->format('Y-m-d'),
        'password' => '1245678',
        'password_confirmation' => '1245678',
    ]);
});
