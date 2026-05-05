<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Questa è la chiave!

class LikeController extends Controller
{
    public function store(Post $post)
    {
        // Usiamo Auth::id() che VS Code riconosce senza problemi
        $userId = Auth::id();

        $like = $post->likes()->where('user_id', $userId);

        if ($like->exists()) {
            $like->delete();
        } else {
            $post->likes()->create([
                'user_id' => $userId,
            ]);
        }

        return back();
    }
}