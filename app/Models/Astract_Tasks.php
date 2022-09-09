<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astract_Tasks extends Model
{
    use HasFactory;

    protected $casts = [
        'deadline' => 'datetime:Y-m-d', // Change date format
        
    ];
}
