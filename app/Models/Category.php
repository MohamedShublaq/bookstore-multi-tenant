<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;

class Category extends TenantModel
{
    protected $fillable = [
        'name',
        'library_id',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_categories', 'category_id', 'coupon_id');
    }
}
