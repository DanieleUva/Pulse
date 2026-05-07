<?php

namespace App\Http\Controllers;

use App\Models\User;
use id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    if ($request->hasFile('avatar')) {
        // --- IL TOCCO DA PRO: ---
        // Se l'utente ha già un avatar salvato, lo cancelliamo prima di caricare il nuovo
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        // -------------------------

        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($data);

    return redirect()->route('users.show', $user->username)->with('success', 'Profilo aggiornato!');
}

    public function toggleFollow(User $user) 
{
    $me = auth()->user();

    if ($me->isFollowing($user)) {
        $me->following()->detach($user->id);
    } else {
        $me->following()->attach($user->id);

        // Notifichiamo l'utente ($user) che io ($me) ho iniziato a seguirlo
        $user->notify(new \App\Notifications\UserFollowed($me));
    }

    return back();
}

   public function index(Request $request)
{
    $search = $request->query('search');

    $users = User::where('id', '!=', auth()->id())
        ->when($search, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        })
        ->get();

    return view('users.explore', compact('users'));
}
}