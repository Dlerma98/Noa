<?php

namespace App\Http\Controllers;

use App\Events\PostPublished;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Jobs\GeneratePostPDF;
use App\Models\Genre;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

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
        return view('posts.create', ['genres' => $genres, 'post' => new Post()]);
    }

    public function store(StorePostRequest $request)
    {

        if (!auth()->user()->hasAnyRole(['admin', 'redactor'])) {
            abort(403, 'No tienes permiso para crear posts.');
        }

        // Validar los datos sin la imagen
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = null; // Se actualizará después con Livewire

        // Crear el post sin imagen
        $post = Post::create($data);

        // Evento para envío de correo una vez se crea el post
        event(new PostPublished($post));

        // Redirigir a la página de edición para que el usuario suba la imagen con Livewire
        return redirect()->route('posts.edit', $post->id)->with('status', 'Post creado con éxito. Ahora sube una imagen si lo deseas.');
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

        return to_route('posts.show', $post)->with('status', 'Post actualizado exitosamente!');

    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return to_route('posts.index')->with('status', 'Post eliminado exitosamente!');
    }

    public function myPosts() {
        $posts = Post::ownedBy(auth()->id())->get();
        return view('posts.myposts', compact('posts'));
    }

    public function generatePdf(Post  $post)
    {
        $post = Post::find($post->id);

        $filePath = "pdfs/post-{$post->id}.pdf";

        // Verificar si el PDF ya existe, si no, generar en segundo plano
        if (!Storage::disk('public')->exists($filePath)) {
            dispatch(new GeneratePostPDF($post));

            return back()->with('status', 'El PDF está siendo generado. Inténtalo nuevamente en unos segundos.');
        }

        // Si ya existe, devolver el archivo
        return response()->download(storage_path("app/public/{$filePath}"));
    }

}
