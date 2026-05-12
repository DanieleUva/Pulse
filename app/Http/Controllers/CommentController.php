<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment; // <-- Fondamentale: aggiungi questa riga!
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate(['body' => 'required|max:255']);

    $comment = $post->comments()->create([
        'body' => $request->body,
        'user_id' => auth()->id(),
    ]);

    // Invia notifica al proprietario del post (se non è chi commenta)
    // Invia notifica al proprietario del post
if ($post->user_id !== auth()->id()) {
    // Usiamo il metodo corretto per le notifiche di database di Laravel
    $post->user->notifications()->create([
        'id' => \Illuminate\Support\Str::uuid(), // Generiamo un ID unico (UUID) come vuole Laravel
        'type' => 'comment',
        'data' => [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'post_id' => $post->id,
            'comment_body' => $request->body, // Aggiungiamo questo così appare nella pagina notifiche
        ],
    ]);
}

    return back()->with('success', 'Commento pubblicato!');
}
   public function destroy(Comment $comment) {
    if(auth()->id() !== $comment->user_id) abort(403);
    $comment->delete();
    return back();
}
}