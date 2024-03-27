<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'animal', 'description', 'user_id', 'image', 'video'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
