<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponBook extends Model
{
    protected $fillable = [
        'coupon_id',
        'book_id',
    ];
}
