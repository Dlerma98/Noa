<?php


use function Pest\Laravel\get;

it('can access the posts index route', function () {
    $response = get(route('posts.index'));
    $response->assertStatus(200);
    $response->assertSee('Listado de Posts'); // Verifica contenido específico en la vista
});
