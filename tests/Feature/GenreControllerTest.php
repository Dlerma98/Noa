<?php

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

    // Crear un usuario con rol admin
    $this->admin = User::factory()->create()->assignRole('admin');

    // Crear géneros de prueba
    $this->genres = Genre::factory()->count(3)->create();
});

test('un admin autenticado puede ver la lista de géneros', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('genres.index'));

    $response->assertStatus(200)
        ->assertViewHas('genres');
});

test('un admin autenticado puede ver el formulario de creación de género', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('genres.create'));

    $response->assertStatus(200);
});

test('un admin autenticado puede crear un género', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('genres.store'), [
            'name' => 'Nuevo Género',
        ]);

    $response->assertRedirect(route('genres.index'))
        ->assertSessionHas('status', 'Género creado con éxito.');

    expect(Genre::where('name', 'Nuevo Género')->exists())->toBeTrue();
});

test('un admin autenticado puede ver el formulario de edición de un género', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('genres.edit', $this->genres->first()));

    $response->assertStatus(200)
        ->assertViewHas('genre');
});

test('un admin autenticado puede actualizar un género', function () {
    $genre = $this->genres->first();

    $response = $this->actingAs($this->admin)
        ->put(route('genres.update', $genre), [
            'name' => 'Género Actualizado',
        ]);

    $response->assertRedirect(route('genres.index'))
        ->assertSessionHas('status', 'Género actualizado con éxito.');

    expect($genre->fresh()->name)->toBe('Género Actualizado');
});

test('un admin autenticado puede eliminar un género', function () {
    $genre = $this->genres->first();

    $response = $this->actingAs($this->admin)
        ->delete(route('genres.destroy', $genre));

    $response->assertRedirect(route('genres.index'))
        ->assertSessionHas('status', 'Género eliminado.');

    expect(Genre::where('id', $genre->id)->exists())->toBeFalse();
});

test('el nombre del género es obligatorio', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('genres.store'), [
            'name' => '',
        ]);

    $response->assertSessionHasErrors('name');
});

test('el nombre del género debe ser único', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('genres.store'), [
            'name' => $this->genres->first()->name,
        ]);

    $response->assertSessionHasErrors('name');
});
