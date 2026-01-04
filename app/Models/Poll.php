<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'user_id',
        'question',
        'expires_on',
        'is_active',
    ];
}
