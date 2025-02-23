<?php

use App\Models\User;
use App\Models\Analysis;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear roles
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor']);
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector']);

    // Crear usuarios con diferentes roles
    $this->admin = User::factory()->create()->assignRole('admin');
    $this->redactor = User::factory()->create()->assignRole('redactor');
    $this->lector = User::factory()->create()->assignRole('lector');

    // Crear un género para los análisis
    $this->genre = Genre::factory()->create();

    // Crear un análisis de prueba
    $this->analysis = Analysis::factory()->create([
        'user_id' => $this->redactor->id,
        'genre_id' => $this->genre->id,
    ]);
});

test('cualquier usuario puede ver la lista de análisis', function () {
    $response = $this->get(route('analyses.index'));

    $response->assertStatus(200);
    $response->assertViewHas('analyses');
});

test('cualquier usuario puede ver un análisis específico', function () {
    $response = $this->get(route('analyses.show', $this->analysis));

    $response->assertStatus(200);
    $response->assertSee($this->analysis->title);
});

test('solo un admin o redactor puede crear un análisis', function () {
    // Un redactor puede crear un análisis
    $response = $this->actingAs($this->redactor)
        ->postJson(route('analyses.store'), [
            'title' => 'Nuevo Análisis',
            'content' => 'Contenido válido con más de 30 caracteres.',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertRedirect();
    expect(Analysis::where('title', 'Nuevo Análisis')->exists())->toBeTrue();

    // Un lector no puede crear un análisis
    $response = $this->actingAs($this->lector)
        ->postJson(route('analyses.store'), [
            'title' => 'Análisis no permitido',
            'content' => 'Contenido',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertStatus(403);
    expect(Analysis::where('title', 'Análisis no permitido')->exists())->toBeFalse();
});

test('solo el dueño del análisis o un admin pueden editarlo', function () {
    // Un redactor dueño del análisis puede editarlo
    $response = $this->actingAs($this->redactor)
        ->get(route('analyses.edit', $this->analysis));

    $response->assertStatus(200);

    // Un admin también puede editar cualquier análisis
    $response = $this->actingAs($this->admin)
        ->get(route('analyses.edit', $this->analysis));

    $response->assertStatus(200);

    // Un lector no puede editar el análisis
    $response = $this->actingAs($this->lector)
        ->get(route('analyses.edit', $this->analysis));

    $response->assertStatus(403);
});

test('solo el dueño del análisis o un admin pueden eliminarlo', function () {
    // Un redactor dueño del análisis puede eliminarlo
    $response = $this->actingAs($this->redactor)
        ->delete(route('analyses.destroy', $this->analysis));

    $response->assertRedirect(route('analyses.index'));
    expect(Analysis::where('id', $this->analysis->id)->exists())->toBeFalse();

    // Un admin también puede eliminar cualquier análisis
    $analysis = Analysis::factory()->create(['user_id' => $this->redactor->id]);

    $response = $this->actingAs($this->admin)
        ->delete(route('analyses.destroy', $analysis));

    $response->assertRedirect(route('analyses.index'));
    expect(Analysis::where('id', $analysis->id)->exists())->toBeFalse();

    // Un lector no puede eliminar análisis
    $response = $this->actingAs($this->lector)
        ->delete(route('analyses.destroy', $this->analysis));

    $response->assertStatus(403);
});

test('un usuario autenticado puede ver sus propios análisis', function () {
    $response = $this->actingAs($this->redactor)
        ->get(route('analyses.myanalyses'));

    $response->assertStatus(200);
    $response->assertViewHas('analyses');
});

