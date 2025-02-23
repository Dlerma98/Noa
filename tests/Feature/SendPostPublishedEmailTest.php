<?php

use App\Events\PostPublished;
use App\Listeners\SendPostPublishedEmail;
use App\Mail\PostPublishedMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear roles antes de asignarlos a los usuarios
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor', 'guard_name' => 'web']);

    // Crear usuario con rol redactor
    $this->user = User::factory()->create()->assignRole('redactor');

    // Crear un post de prueba
    $this->post = Post::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Título de prueba',
        'content' => 'Contenido de prueba con más de 30 caracteres.',
    ]);
});

test('el listener SendPostPublishedEmail se activa cuando se publica un post', function () {
    Event::fake();

    event(new PostPublished($this->post));

    Event::assertDispatched(PostPublished::class);
    Event::assertListening(PostPublished::class, SendPostPublishedEmail::class);
});

test('el listener envía un correo cuando se publica un post', function () {

    Mail::fake();

    $listener = new SendPostPublishedEmail();
    $listener->handle(new PostPublished($this->post));

    Mail::assertSent(PostPublishedMail::class);

});

