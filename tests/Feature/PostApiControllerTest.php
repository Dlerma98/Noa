<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);

    $this->user = User::factory()->create()->assignRole('redactor');

    // Crear 3 posts en la base de datos
    $this->posts = Post::factory()->count(3)->create();
});

test('la API devuelve una lista paginada de posts', function () {
    $response = $this->actingAs($this->user)
        ->getJson(route('api.posts.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'content', 'genre_id', 'user_id', 'created_at', 'updated_at']
            ]
        ]);
});
