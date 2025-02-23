<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear los roles antes de usarlos
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);

    // Crear usuario autenticado con el rol correcto
    $this->user = User::factory()->create()->assignRole('redactor');

    // Crear un post asociado al comentario
    $this->post = Post::factory()->create();

    // Crear un comentario de prueba
    $this->comment = Comment::factory()->create(['post_id' => $this->post->id, 'user_id' => $this->user->id]);
});
test('se puede crear un comentario correctamente', function () {
    $comment = Comment::factory()->create([
        'content' => 'Este es un comentario de prueba.',
    ]);

    expect($comment)->toBeInstanceOf(Comment::class);
    expect($comment->content)->toBe('Este es un comentario de prueba.');
});

test('un comentario pertenece a un usuario', function () {
    expect($this->comment->user)->toBeInstanceOf(User::class);
    expect($this->comment->user->id)->toBe($this->user->id);
});

test('un comentario pertenece a un post', function () {
    expect($this->comment->post)->toBeInstanceOf(Post::class);
    expect($this->comment->post->id)->toBe($this->post->id);
});

test('un comentario puede tener respuestas (comentarios anidados)', function () {
    $reply = Comment::factory()->create([
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'parent_id' => $this->comment->id,
    ]);

    expect($reply->parent)->toBeInstanceOf(Comment::class);
    expect($reply->parent->id)->toBe($this->comment->id);
});

test('un comentario se elimina si se elimina el post (cascade delete)', function () {
    $this->post->delete();

    expect(Comment::where('post_id', $this->post->id)->exists())->toBeFalse();
});

test('un comentario requiere contenido', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    Comment::create([
        'content' => null,
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
    ]);
});

test('el contenido de un comentario debe tener al menos 5 caracteres', function () {
    $response = $this->actingAs($this->user)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => 'Hey', // Menos de 5 caracteres
        ]);

    $response->assertSessionHasErrors('content');
});

test('parent_id debe ser un comentario existente', function () {
    $response = $this->actingAs($this->user)
        ->post(route('comments.store'), [
            'post_id' => $this->post->id,
            'content' => 'Respuesta a un comentario inexistente.',
            'parent_id' => 99999,
        ]);

    $response->assertRedirect(); // Laravel redirige en caso de error
    $response->assertSessionHasErrors('parent_id');
});
