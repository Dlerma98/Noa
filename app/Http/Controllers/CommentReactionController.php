<?php

namespace App\Http\Controllers;

use App\Models\CommentReaction;
use Illuminate\Http\Request;

class CommentReactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'reaction_type' => 'required|in:like,love,angry,sad,laugh'
        ]);

        // Buscar si el usuario ya reaccionó a este comentario
        $reaction = CommentReaction::where('user_id', auth()->id())
            ->where('comment_id', $request->comment_id)
            ->first();

        if ($reaction) {
            // Si ya reaccionó y la reacción es la misma, eliminarla (toggle)
            if ($reaction->reaction_type === $request->reaction_type) {
                $reaction->delete();
                return back()->with('success', 'Reacción eliminada.');
            }

            // Si reaccionó pero con otro tipo, actualizarla
            $reaction->update(['reaction_type' => $request->reaction_type]);
        } else {
            // Crear una nueva reacción
            CommentReaction::create([
                'comment_id' => $request->comment_id,
                'user_id' => auth()->id(),
                'reaction_type' => $request->reaction_type
            ]);
        }

        return back()->with('success', 'Reacción registrada.');
    }
}
