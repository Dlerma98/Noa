<?php

namespace App\Http\Controllers;

use App\Events\PostPublished;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Genre;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::paginate(12);

        return view('posts.index', compact('posts'));
    }


    public function show(Post $post)
    {

        return view('posts.show', compact('post'));

    }

    public function create()
    {
        $genres = Genre::all();
        return view('posts.create', [
            'genres' => $genres,
            'post' => new Post()
        ]);
    }

    public function store(StorePostRequest $request)
    {
        // Validar los datos sin la imagen
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = null; // Se actualizará después con Livewire

        // Crear el post sin imagen
        $post = Post::create($data);

        //Evento para envio de correo una vez se crea el post
        event(new PostPublished($post));
        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('posts.edit', $post->id)->with('status', 'Post creado con éxito. Ahora sube una imagen.');
    }



    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $genres = Genre::all();
        return view('posts.edit', compact('post','genres'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $post -> update($request->validated());

        return to_route('posts.show', $post)->with('status', 'Post updated successfully!');

    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return to_route('posts.index')->with('status', 'Post deleted successfully!');
    }

    public function myPosts() {
        $posts = Post::ownedBy(auth()->id())->get();
        return view('posts.myposts', compact('posts'));
    }

}
