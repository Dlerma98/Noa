<?php

use App\Models\Comment;
use App\Models\CommentReaction;
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

    // Crear un post y un comentario asociado
    $this->post = Post::factory()->create();
    $this->comment = Comment::factory()->create(['post_id' => $this->post->id]);
});

test('un usuario autenticado puede reaccionar a un comentario', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'like',
        ]);

    $response->assertRedirect(); // Laravel redirige después de éxito
    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'like')
        ->exists())->toBeTrue();
});

test('un usuario no autenticado no puede reaccionar a un comentario', function () {
    $response = $this->post(route('comments.reactions.store'), [
        'comment_id' => $this->comment->id,
        'reaction_type' => 'love',
    ]);

    $response->assertRedirect(route('login')); // Laravel redirige a login
});

test('un usuario no puede reaccionar a un comentario inexistente', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => 99999, // ID inexistente
            'reaction_type' => 'angry',
        ]);

    $response->assertSessionHasErrors('comment_id');
});

test('un usuario solo puede usar reacciones válidas', function () {
    $response = $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'invalid_reaction',
        ]);

    $response->assertSessionHasErrors('reaction_type');
});

test('un usuario puede alternar (toggle) una reacción', function () {
    $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'laugh',
        ]);

    // La reacción debe existir
    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'laugh')
        ->exists())->toBeTrue();

    // Segunda solicitud con la misma reacción la elimina (toggle)
    $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'laugh',
        ]);

    // La reacción debe haber sido eliminada
    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'laugh')
        ->exists())->toBeFalse();
});

test('un usuario puede cambiar su reacción', function () {
    $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'like',
        ]);

    // La reacción inicial debe ser 'like'
    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'like')
        ->exists())->toBeTrue();

    // Cambiar la reacción a 'sad'
    $this->actingAs($this->redactor)
        ->post(route('comments.reactions.store'), [
            'comment_id' => $this->comment->id,
            'reaction_type' => 'sad',
        ]);

    // Ahora la reacción debe ser 'sad' en lugar de 'like'
    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'like')
        ->exists())->toBeFalse();

    expect(CommentReaction::where('comment_id', $this->comment->id)
        ->where('user_id', $this->redactor->id)
        ->where('reaction_type', 'sad')
        ->exists())->toBeTrue();
});
