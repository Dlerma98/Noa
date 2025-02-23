<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear roles antes de asignarlos a los usuarios
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector', 'guard_name' => 'web']);

    // Crear usuarios
    $this->admin = User::factory()->create()->assignRole('admin');
    $this->redactor = User::factory()->create()->assignRole('redactor');
    $this->lector = User::factory()->create()->assignRole('lector');

    // Crear un post para asociar comentarios
    $this->post = Post::factory()->create();
});

test('un usuario autenticado puede comentar en un post', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => 'Este es un comentario de prueba.',
        ]);

    $response->assertRedirect(); // Laravel redirige después de éxito
    expect(Comment::where('content', 'Este es un comentario de prueba.')->exists())->toBeTrue();
});

test('un usuario no autenticado no puede comentar en un post', function () {
    $response = $this->post(route('comments.store'), [
        'post_id' => $this->post->id,
        'content' => 'Intento de comentario.',
    ]);

    $response->assertRedirect(route('login')); // Laravel redirige a login
});

test('validación: un comentario no puede estar vacío', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => '',
        ]);

    $response->assertSessionHasErrors('content');
});

test('validación: un comentario debe tener máximo 1000 caracteres', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => str_repeat('a', 1001), // Más de 1000 caracteres
        ]);

    $response->assertSessionHasErrors('content');
});

test('validación: un comentario con un parent_id inválido no se puede agregar', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => 'Respuesta a un comentario inexistente.',
            'parent_id' => 99999, // ID de comentario que no existe
        ]);

    $response->assertSessionHasErrors('parent_id');
});
