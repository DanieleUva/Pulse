<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment; // <-- Fondamentale: aggiungi questa riga!
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|max:255',
        ]);

        $post->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Commento pubblicato!');
    }

    public function destroy(Comment $comment)
    {
        // Verifichiamo che chi cancella sia l'autore del commento
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Commento eliminato!');
    }
}