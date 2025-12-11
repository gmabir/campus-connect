<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    // We use guarded = [] which means "Guard nothing, allow everything"
    protected $guarded = []; 
}