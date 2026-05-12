<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Moment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'image_path', 'expires_at'];

    // Cast per gestire la data come oggetto Carbon
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}