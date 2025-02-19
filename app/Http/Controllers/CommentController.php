<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        {
            $request->validate([
                'post_id' => 'required|exists:posts,id',
                'content' => 'required|string|max:1000',
                'parent_id' => 'nullable|exists:comments,id' // Permite respuestas
            ]);

            Comment::create([
                'post_id' => $request->post_id,
                'user_id' => auth()->id(),
                'content' => $request->content,
                'parent_id' => $request->parent_id
            ]);

            return back()->with('success', 'Comentario agregado.');
        }
    }
}
