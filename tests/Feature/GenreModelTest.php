<?php

use App\Models\Genre;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear los roles antes de usarlos
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);

    // Crear usuario autenticado con el rol correcto
    $this->admin = User::factory()->create()->assignRole('admin');

    // Crear un género de prueba
    $this->genre = Genre::factory()->create();
});

test('se puede crear un género correctamente', function () {
    $genre = Genre::factory()->create([
        'name' => 'Acción',
    ]);

    expect($genre)->toBeInstanceOf(Genre::class);
    expect($genre->name)->toBe('Acción');
});

test('un género puede tener múltiples posts', function () {
    $genre = Genre::factory()->create();
    Post::factory()->count(3)->create(['genre_id' => $genre->id]);

    expect($genre->posts)->toHaveCount(3);
    expect($genre->posts->first())->toBeInstanceOf(Post::class);
});

test('un género requiere un nombre', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Genre::create(['name' => null]);
});

test('el nombre del género debe ser único', function () {
    Genre::factory()->create(['name' => 'Terror']);

    $this->expectException(\Illuminate\Database\QueryException::class);

    Genre::create(['name' => 'Terror']); // Intentar crear otro género con el mismo nombre
});
