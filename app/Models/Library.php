<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'currency',
        'logo',
        'status',
    ];

    public function getCreatedAtAttribute($val)
    {
        return date('Y/m/d - H:i A', strtotime($val));
    }
}
