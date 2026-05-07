<?php

namespace App\Http\Controllers;

use App\Models\Post; // Fondamentale per Post::
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Serve per gestire i file

class PostController extends Controller
{
    public function index()
    {
        // Carichiamo anche i commenti per evitare errori nella home
        $posts = Post::with(['user', 'likes', 'comments'])->latest()->get();
        return view('home', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Questo salva il file e mette il percorso in $imagePath
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Qui è dove devi assicurarti di salvare 'image' nel database!
        Auth::user()->posts()->create([
            'body' => $request->body,
            'image' => $imagePath, // <--- ASSICURATI CHE CI SIA QUESTA RIGA
        ]);

        return back()->with('success', 'Post pubblicato!');
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        // Opzionale: cancella l'immagine dal disco se il post viene eliminato
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Post eliminato con successo!');
    }
}