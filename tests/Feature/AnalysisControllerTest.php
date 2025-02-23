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



test('solo el dueño del análisis puede editarlo', function () {
    $response = $this->actingAs($this->redactor)
        ->get(route('analyses.edit', $this->analysis));

    $response->assertStatus(200);
});

test('solo el admin puede editar cualquier analisis', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('analyses.edit', $this->analysis));

    $response->assertStatus(200);
});

test('solo el dueño del análisis puede eliminarlo', function () {
    // Un redactor dueño del análisis puede eliminarlo
    $response = $this->actingAs($this->redactor)
        ->delete(route('analyses.destroy', $this->analysis));

    $response->assertRedirect(route('analyses.index'));
    expect(Analysis::where('id', $this->analysis->id)->exists())->toBeFalse();

});

test('Un admin puede eliminar un analisis', function() {
    $analysis = Analysis::factory()->create(['user_id' => $this->redactor->id]);

    $response = $this->actingAs($this->admin)
        ->delete(route('analyses.destroy', $analysis));

    $response->assertRedirect(route('analyses.index'));
    expect(Analysis::where('id', $analysis->id)->exists())->toBeFalse();
});


test('un usuario autenticado puede ver sus propios análisis', function () {
    $response = $this->actingAs($this->redactor)
        ->get(route('analysis.myanalyses'));

    $response->assertStatus(200);
    $response->assertViewHas('analyses');
});

test('un redactor no puede crear un análisis sin título', function () {
    $response = $this->actingAs($this->redactor)
        ->postJson(route('analyses.store'), [
            'content' => 'Contenido válido con más de 30 caracteres.',
            'score' => 50,
            'console' => 'PC',
            'type' => 'Retro',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('un redactor no puede crear un análisis con puntaje fuera de rango', function () {
    $response = $this->actingAs($this->redactor)
        ->postJson(route('analyses.store'), [
            'title' => 'Nuevo Análisis',
            'content' => 'Contenido válido con más de 30 caracteres.',
            'score' => 150, // Fuera del rango 0-100
            'console' => 'PC',
            'type' => 'Retro',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['score']);
});

test('un usuario sin análisis recibe una lista vacía', function () {
    Analysis::truncate(); // <-- Borra todos los análisis antes de la prueba

    $response = $this->actingAs($this->redactor)
        ->get(route('analysis.myanalyses'));

    $response->assertStatus(200);
    $response->assertViewHas('analyses', function ($analyses) {
        return $analyses->isEmpty();
    });
});


test('un lector no puede eliminar un análisis', function () {
    $response = $this->actingAs($this->lector)
        ->delete(route('analyses.destroy', $this->analysis));

    $response->assertStatus(403);
});


