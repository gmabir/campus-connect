<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'caption',
        'image_path',
        'original_name',
        'mime_type',
        'file_size',
    ];
}
