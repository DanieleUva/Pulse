<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostLiked; // <-- 1. Importa la notifica
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $user = Auth::user(); // Prendi l'intero oggetto utente
        $userId = $user->id;

        $like = $post->likes()->where('user_id', $userId);

        if ($like->exists()) {
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => $userId,
            ]);

            // --- 2. LOGICA NOTIFICA ---
            // Inviamo la notifica solo se il post non è il mio
            if ($post->user_id !== $userId) {
                $post->user->notify(new PostLiked($user, $post));
            }
            // --------------------------
        }

        return back();
    }
}