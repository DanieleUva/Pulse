<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        // Prendiamo tutti i post di questo utente, ordinati dal più recente
        $posts = $user->posts()->latest()->get();

        // Passiamo l'utente e i suoi post alla vista
        return view('users.show', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        // Un utente può modificare solo il PROPRIO profilo
        if (auth()->id() !== $user->id) {
            abort(403, 'Non sei autorizzato a modificare questo profilo.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->id() !== $user->id) {
            abort(403);
        }

        $request->validate([
            'bio' => 'nullable|max:255',
            'location' => 'nullable|max:50',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('bio', 'location');

        // Se l'utente carica una foto, la salviamo e aggiungiamo il percorso ai dati
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', 'Profilo aggiornato!');
    }
}