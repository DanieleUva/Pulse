<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Importante: così il controller conosce il modello Post

class PostController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'body' => 'required|max:255',
    ]);

    // Creiamo il post collegandolo all'utente autenticato
    $request->user()->posts()->create([
        'body' => $request->body,
    ]);

    return redirect('/');
}
}