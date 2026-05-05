<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;


#[Fillable(['name', 'username', 'email', 'password', 'avatar', 'bio', 'location', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Helper per ottenere l'URL dell'avatar o un'immagine di default
     */
    public function getAvatarUrl()
    {
        return $this->avatar 
            ? Storage::url($this->avatar) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Relazione: Un utente può avere molti post.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relazione: Un utente può mettere molti like.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}