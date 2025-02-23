<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Genre;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear los roles antes de usarlos
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector', 'guard_name' => 'web']);

    // Crear usuario autenticado con el rol correcto
    $this->user = User::factory()->create()->assignRole('redactor');

    // Crear un género asociado al post
    $this->genre = Genre::factory()->create();

    // Crear un post de prueba
    $this->post = Post::factory()->create(['user_id' => $this->user->id, 'genre_id' => $this->genre->id]);
});

test('puede crearse un post correctamente', function () {
    $post = Post::factory()->create([
        'title' => 'Título de prueba',
        'content' => 'Contenido de prueba con más de 30 caracteres.',
    ]);

    expect($post)->toBeInstanceOf(Post::class);
    expect($post->title)->toBe('Título de prueba');
});

test('un post pertenece a un usuario', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    expect($post->user)->toBeInstanceOf(User::class);
    expect($post->user->id)->toBe($user->id);
});

test('un post pertenece a un género', function () {
    $genre = Genre::factory()->create();
    $post = Post::factory()->create(['genre_id' => $genre->id]);

    expect($post->genre)->toBeInstanceOf(Genre::class);
    expect($post->genre->id)->toBe($genre->id);
});

test('un post puede tener múltiples comentarios', function () {
    $post = Post::factory()->create();
    Comment::factory()->count(3)->create(['post_id' => $post->id]);

    expect($post->comments)->toHaveCount(3);
    expect($post->comments->first())->toBeInstanceOf(Comment::class);
});

test('un post requiere título y contenido', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Post::create([
        'title' => null,
        'content' => null,
    ]);
});

