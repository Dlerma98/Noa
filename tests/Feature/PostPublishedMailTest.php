<?php

use App\Mail\PostPublishedMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

beforeEach(function () {
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);

    $this->user = User::factory()->create()->assignRole('redactor');

    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Título de prueba',
        'content' => 'Contenido de prueba con más de 30 caracteres.',
    ]);
});

test('se puede instanciar el correo PostPublishedMail', function () {
    $mail = new PostPublishedMail($this->post);

    expect($mail)->toBeInstanceOf(PostPublishedMail::class);
});

test('el correo contiene la información del post', function () {
    $mail = new PostPublishedMail($this->post);
    $mail->assertSeeInHtml($this->post->title);
    $mail->assertSeeInHtml($this->post->content);
});

test('el correo se puede renderizar correctamente en HTML y texto plano', function () {
    $mail = new PostPublishedMail($this->post);

    expect($mail->render())->toContain($this->post->title);
    expect($mail->render())->toContain($this->post->content);
});

test('el correo se envía cuando se publica un post', function () {
    Mail::fake();

    Mail::to('test@example.com')->send(new PostPublishedMail($this->post));

    Mail::assertSent(PostPublishedMail::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});
