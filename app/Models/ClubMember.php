<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubMember extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'club_id',
        'user_id',
        'joined_at',
    ];
}
