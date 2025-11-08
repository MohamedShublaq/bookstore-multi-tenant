<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleCategory extends Model
{
    protected $fillable = [
        'flash_sale_id',
        'category_id',
    ];
}
