<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(User $user)
    {
        // Segna i messaggi ricevuti da questo utente come letti
        Message::where('sender_id', $user->id)
       ->where('receiver_id', auth()->id())
       ->update(['is_read' => true]);
       
        // Recupera la conversazione tra te e l'altro utente
        $messages = Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($user) {
          $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate(['body' => 'required']);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $request->body,
        ]);

        return back();
    }

    public function index()
    {
        $userId = auth()->id();

        // Recupera tutti gli utenti con cui c'è stata una conversazione
        $users = User::whereHas('messagesSent', function($q) use ($userId) {
            $q->where('receiver_id', $userId);
        })->orWhereHas('messagesReceived', function($q) use ($userId) {
            $q->where('sender_id', $userId);
        })->withCount(['messagesReceived as unread_count' => function($q) use ($userId) {
            $q->where('receiver_id', $userId)->where('is_read', false);
        }])->get();

        return view('chat.index', compact('users'));
    }
}