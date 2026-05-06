<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    // Questa riga è quella che risolve l'errore:
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'body', 
        'is_read'
    ];

    // Opzionale: aggiungi questa relazione per caricare l'utente che invia
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}