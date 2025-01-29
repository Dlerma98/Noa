<?php

namespace App\Http\Controllers;

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
        $posts = $posts->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }
}
