<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Crear roles
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'redactor']);
    Spatie\Permission\Models\Role::firstOrCreate(['name' => 'lector']);

    // Crear usuarios con diferentes roles
    $this->admin = User::factory()->create()->assignRole('admin');
    $this->redactor = User::factory()->create()->assignRole('redactor');
    $this->lector = User::factory()->create()->assignRole('lector');

    // Crear un género para los posts
    $this->genre = Genre::factory()->create();

    // Crear un post de prueba
    $this->post = Post::factory()->create([
        'user_id' => $this->redactor->id,
        'genre_id' => $this->genre->id,
    ]);
});

test('cualquier usuario puede ver la lista de posts', function () {
    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
    $response->assertViewHas('posts');
});

test('cualquier usuario puede ver un post específico', function () {
    $response = $this->get(route('posts.show', $this->post));

    $response->assertStatus(200);
    $response->assertSee($this->post->title);
});



test('solo el dueño del post puede editarlo', function () {
    // Un redactor dueño del post puede editarlo
    $response = $this->actingAs($this->redactor)
        ->get(route('posts.edit', $this->post));

    $response->assertStatus(200);

});

test('Solo el admin puede editar cualquier post', function () {
    // Un admin también puede editar cualquier post
    $response = $this->actingAs($this->admin)
        ->get(route('posts.edit', $this->post));

    $response->assertStatus(200);
});

test('Un lector no puede eliminar un post', function () {
    // Asegurar que el post existe antes de la prueba
    expect(Post::where('id', $this->post->id)->exists())->toBeTrue();

    // Un lector intenta eliminar un post
    $response = $this->actingAs($this->lector)
        ->delete(route('posts.destroy', $this->post));

    // Verifica el codigo de estado pero no tiene en cuenta el html
    $response->assertForbidden(); // Es equivalente a ->assertStatus(403)
});

test('solo el dueño del post puede eliminarlo', function () {
    // Un redactor dueño del análisis puede eliminarlo
    $response = $this->actingAs($this->redactor)
        ->delete(route('posts.destroy', $this->post));

    $response->assertRedirect(route('posts.index'));
    expect(Post::where('id', $this->post->id)->exists())->toBeFalse();
});

test('solo el admin puede eliminar cualquier post', function () {
    $post = Post::factory()->create(['user_id' => $this->redactor->id]);

    $response = $this->actingAs($this->admin)
        ->delete(route('posts.destroy', $post));

    $response->assertRedirect(route('posts.index'));
    expect(Post::where('id', $post->id)->exists())->toBeFalse();
});



test('un usuario autenticado puede ver sus propios posts', function () {
    $response = $this->actingAs($this->redactor)
        ->get(route('posts.myposts'));

    $response->assertStatus(200);
    $response->assertViewHas('posts');
});

test('se puede generar un PDF de un post', function () {

    $filePath = "pdfs/post-{$this->post->id}.pdf";

    // Eliminar el PDF si existe antes de la prueba
    Storage::disk('public')->delete($filePath);

    $response = $this->actingAs($this->redactor)
        ->get(route('posts.pdf', $this->post));

    $response->assertRedirect();
});

test('un redactor no puede crear un post sin título', function () {
    $response = $this->actingAs($this->redactor)
        ->postJson(route('posts.store'), [
            'excerpt' => 'Post de prueba',
            'content' => 'Contenido de prueba largo',
            'category' => 'Xbox',
            'type' => 'Exclusive',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});



test('un redactor no puede actualizar un post con título vacío', function () {
    $response = $this->actingAs($this->redactor)
        ->put(route('posts.update', $this->post), [
            'title' => '',
            'excerpt' => 'Post de pruebaPost de prueba',
            'content' => 'Post de pruebaPost de pruebaPost de pruebaPost de pruebaPost de prueba',
            'category' => 'Xbox',
            'type' => 'Exclusive',
            'genre_id' => $this->genre->id,
        ]);

    $response->assertSessionHasErrors('title');
    expect($this->post->fresh()->title)->not->toBe('');
});

test('un usuario no autenticado no puede crear un post', function () {
    $response = $this->post(route('posts.store'), [
        'title' => 'Post sin autenticación',
        'content' => 'Contenido válido con más de 30 caracteres.',
        'genre_id' => $this->genre->id,
    ]);

    $response->assertRedirect(route('login'));
});




test('un usuario no autenticado no puede ver la página de creación de posts', function () {
    $response = $this->get(route('posts.create'));

    $response->assertRedirect(route('login'));
});


test('un admin recibe 404 al intentar eliminar un post inexistente', function () {
    $response = $this->actingAs($this->admin)
        ->delete(route('posts.destroy', 9999)); // Un ID que no existe

    $response->assertStatus(404);
});



test('un usuario puede descargar un PDF si ya existe', function () {
    $filePath = "pdfs/post-{$this->post->id}.pdf";

    // Simular que el PDF ya fue generado
    Storage::disk('public')->put($filePath, 'Contenido falso del PDF');

    $response = $this->actingAs($this->redactor)
        ->get(route('posts.pdf', $this->post));

    // Esperamos que el archivo se descargue, lo cual devuelve un 200
    $response->assertStatus(200);

    // Limpiar después de la prueba
    Storage::disk('public')->delete($filePath);
});
