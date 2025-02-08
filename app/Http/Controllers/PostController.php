<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query();

        // Filtrar por categoría
        if ($request->has('category')) {
            $posts->where('category', $request->input('category'));
        }

        // Filtrar por tipo
        if ($request->has('type')) {
            $posts->where('type', $request->input('type'));
        }

        // Obtener los posts ordenados
        $posts = $posts->orderBy('created_at', 'desc')->paginate(12);

        return view('posts.index', compact('posts'));
    }


    public function show(Post $post)
    {

        return view('posts.show', compact('post'));

    }

    public function create()
    {
        return view('posts.create', ['post' => new Post()]);
    }

    public function store(StorePostRequest $request)
    {
        // Validar los datos sin la imagen
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = null; // Se actualizará después con Livewire

        // Crear el post sin imagen
        $post = Post::create($data);

        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('posts.edit', $post->id)->with('status', 'Post creado con éxito. Ahora sube una imagen.');
    }



    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $post -> update($request->validated());

        return to_route('posts.show', $post)->with('status', 'Post updated successfully!');

    }

    public function destroy(Post $post)
    {

        $post->delete();
        return to_route('posts.index')->with('status', 'Post deleted successfully!');
    }

    public function myPosts() {
        $posts = Post::where('user_id', auth()->user()->id)->get();
        return view('posts.myposts', compact('posts'));
    }

}
