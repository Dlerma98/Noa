<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('un usuario autenticado puede ver su perfil', function () {
    $response = $this->actingAs($this->user)->get(route('profile.update'));

    $response->assertStatus(200);
    $response->assertViewIs('profile.show');
    $response->assertSee($this->user->email);
});

test('un usuario no autenticado no puede acceder al perfil', function () {
    $response = $this->get(route('profile.show'));

    $response->assertRedirect(route('login'));
});



test('un usuario autenticado puede cerrar sesión', function () {
    $response = $this->actingAs($this->user)->delete(route('profile.logout'));

    $response->assertRedirect('/');
    expect(auth()->check())->toBeFalse();
});

test('un usuario menor de 16 años no puede actualizar su perfil', function () {

    $response = $this->actingAs($this->user)->patch(route('profile.update'), [
        'name' => 'Nombre Inválido',
        'lastname' => 'Apellido Inválido',
        'email' => 'invalid@example.com',
        'birthdate' => "2024-10-10",
    ]);

    $response->assertSessionHasErrors('birthdate'); // Laravel debe rechazar el formulario
});
