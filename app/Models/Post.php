<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Permettiamo a Laravel di salvare il testo del post e l'ID dell'utente
#[Fillable(['body', 'user_id'])]
class Post extends Model
{
    /**
     * Relazione Inversa: Ogni post appartiene a un utente.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}