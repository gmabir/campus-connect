<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'department',
        'batch',
        'supervisor_name',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];
}
