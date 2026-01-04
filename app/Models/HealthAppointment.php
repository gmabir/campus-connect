<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'appointment_date',
        'appointment_time', // Must be here to fix the 1364 error
        'reason',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}