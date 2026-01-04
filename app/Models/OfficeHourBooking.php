<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeHourBooking extends Model
{
    protected $fillable = [
        'slot_id',
        'student_id',
        'note',
    ];
}
