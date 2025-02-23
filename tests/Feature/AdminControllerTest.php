<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear roles si no existen
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'redactor']);
    Role::firstOrCreate(['name' => 'lector']);

    // Crear un administrador
    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');

    // Crear un usuario lector
    $this->lector = User::factory()->create();
    $this->lector->assignRole('lector');

    // Crear un usuario redactor
    $this->redactor = User::factory()->create();
    $this->redactor->assignRole('redactor');
});

test('un administrador puede acceder al dashboard', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Gestión de Usuarios'); // Asegurar que la vista contiene el contenido esperado
});


test('un administrador puede convertir un lector en redactor', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.makeRedactor', $this->lector))
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('status', 'Usuario ahora es Redactor.');

    expect($this->lector->fresh()->hasRole('redactor'))->toBeTrue();
});

test('un administrador puede convertir un redactor en lector', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.makeLector', $this->redactor))
        ->assertRedirect(route('admin.dashboard'))
        ->assertSessionHas('status', 'Usuario ahora es Lector.');

    expect($this->redactor->fresh()->hasRole('lector'))->toBeTrue();
});

test('un usuario sin permisos no puede cambiar roles', function () {
    $this->actingAs($this->lector)
        ->patch(route('admin.makeRedactor', $this->lector))
        ->assertStatus(403);
});

test('un usuario no autenticado no puede acceder al dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login')); // Laravel redirige a login por el middleware auth
});

test('un usuario no autenticado no puede cambiar roles', function () {
    $response = $this->patch(route('admin.makeRedactor', $this->lector));

    $response->assertRedirect(route('login')); // Debe redirigir a login
});

test('un administrador no puede cambiarse su propio rol', function () {
    $response = $this->actingAs($this->admin)
        ->patch(route('admin.makeLector', $this->admin));

    $response->assertStatus(403); // El admin no debería poder cambiar su propio rol
});

