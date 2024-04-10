<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aanvraag extends Model
{
    use HasFactory;

    protected $fillable = ['user_id_request', 'post_id', 'user_id_post', 'accepted'];
}
