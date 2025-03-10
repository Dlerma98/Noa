<?php

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {

    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);


    $this->user = User::factory()->create()->assignRole('redactor');
    $this->post = Post::factory()->create();

    // Crear comentario asociado
    $this->comment = Comment::factory()->create([
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
    ]);
});

test('se puede crear una reacción correctamente', function () {
    $reaction = CommentReaction::factory()->create([
        'comment_id' => $this->comment->id,
        'user_id' => $this->user->id,
        'reaction_type' => 'like',
    ]);

    expect($reaction)->toBeInstanceOf(CommentReaction::class);
    expect($reaction->reaction_type)->toBe('like');
});

test('una reacción pertenece a un usuario', function () {
    $reaction = CommentReaction::factory()->create([
        'comment_id' => $this->comment->id,
        'user_id' => $this->user->id,
    ]);

    expect($reaction->user)->toBeInstanceOf(User::class);
    expect($reaction->user->id)->toBe($this->user->id);
});

test('una reacción pertenece a un comentario', function () {
    $reaction = CommentReaction::factory()->create([
        'comment_id' => $this->comment->id,
        'user_id' => $this->user->id,
    ]);

    expect($reaction->comment)->toBeInstanceOf(Comment::class);
    expect($reaction->comment->id)->toBe($this->comment->id);
});

test('un usuario puede reaccionar varias veces a un comentario', function () {
    // Crear un comentario y un usuario
    $comment = \App\Models\Comment::factory()->create();
    $user = \App\Models\User::factory()->create();

    // El usuario reacciona con "love"
    \App\Models\CommentReaction::create([
        'comment_id' => $comment->id,
        'user_id' => $user->id,
        'reaction_type' => 'love',
    ]);

    // El usuario reacciona con "angry" (antes fallaba, ahora debe permitirse)
    \App\Models\CommentReaction::create([
        'comment_id' => $comment->id,
        'user_id' => $user->id,
        'reaction_type' => 'angry',
    ]);

    // Contar las reacciones del usuario en el comentario
    $reactionsCount = \App\Models\CommentReaction::where('comment_id', $comment->id)
        ->where('user_id', $user->id)
        ->count();

    // El usuario debería tener al menos 2 reacciones registradas en el comentario
    expect($reactionsCount)->toBeGreaterThan(1);
});


test('solo se pueden usar reacciones válidas', function () {
    $this->expectException(\Illuminate\Database\QueryException::class);

    CommentReaction::create([
        'comment_id' => $this->comment->id,
        'user_id' => $this->user->id,
        'reaction_type' => 'invalid_reaction',
    ]);
});

test('una reacción se elimina si se elimina el comentario (cascade delete)', function () {
    $reaction = CommentReaction::factory()->create([
        'comment_id' => $this->comment->id,
        'user_id' => $this->user->id,
    ]);

    $this->comment->delete();

    expect(CommentReaction::where('id', $reaction->id)->exists())->toBeFalse();
});

