<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeHourSlot extends Model
{
    protected $fillable = [
        'teacher_id',
        'slot_date',
        'slot_time',
        'location',
        'capacity',
    ];
}
