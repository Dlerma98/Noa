<?php

use App\Models\Analysis;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear los roles antes de usarlos
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector', 'guard_name' => 'web']);

    // Crear usuario para la prueba
    $this->user = User::factory()->create()->assignRole('redactor');

    // Crear 3 análisis para verificar que se listan correctamente
    $this->analyses = Analysis::factory()->count(3)->create();
});


test('la API devuelve una lista paginada de análisis', function () {
    $response = $this->actingAs($this->user)
        ->getJson(route('api.analyses.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'content', 'score', 'console', 'type', 'genre_id', 'user_id', 'created_at', 'updated_at']
            ]
        ]);
});
