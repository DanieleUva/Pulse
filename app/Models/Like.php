<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Permettiamo di salvare user_id e post_id
    protected $fillable = ['user_id', 'post_id'];
}
