<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment'
    ];

    // Link comment back to the user who wrote it
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link comment back to the post it belongs to
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}