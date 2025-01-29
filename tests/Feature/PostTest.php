<?php

use App\Models\Post;
use function Pest\Laravel\get;

it('can see a post title', function () {
    //Arrange
    $post = Post::factory()->create();
    //Act & Assert
    get(route('posts.index',$post))
        ->assertSeeText(
            $post->title
        );
});

it('can see a post excerpt', function () {
    //Arrange
    $post = Post::factory()->create();
    //Act & Assert
    get(route('posts.index',$post))
        ->assertSeeText(
            $post->excerpt
        );
});

it('can insert a post into the database', function () {
    $post = Post::factory()->create();

    $this->assertDatabaseHas('posts',[
        'title'=>$post->title,
    ]);
});



it('paginates posts correctly', function () {
    Post::factory()->count(15)->create();

    $response = get('/posts?page=1');
    $response->assertStatus(200);

    // Verifica que solo se muestren los primeros 10 posts
    expect($response->viewData('posts')->count())->toBe(10);
});


