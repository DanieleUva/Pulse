<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'image', 'user_id'];

    /**
     * Relazione con l'utente che ha creato il post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione con i like ricevuti dal post
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Verifica se un determinato utente ha messo like a questo post
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        
        return $this->likes()->where('user_id', $user->id)->exists();
    }

        public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}