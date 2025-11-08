<?php

namespace App\Models;

use App\Models\Discount\DiscountModel;
use App\Observers\CouponObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CouponObserver::class])]
class Coupon extends DiscountModel
{
    protected $fillable = [
        'library_id',
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status',
        'applies_to_all_books',
        'usage_limit',
        'per_user_limit',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'coupon_books', 'coupon_id', 'book_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupon_categories', 'coupon_id', 'category_id');
    }

    public function hasNoDates(): bool
    {
        return ! $this->start_date && ! $this->end_date;
    }

    public function isWithinDateRange(): bool
    {
        if (! $this->start_date || ! $this->end_date) {
            return false;
        }

        $today = Carbon::today();
        return $today >= $this->start_date && $today < $this->end_date;
    }

    public function showStartDate()
    {
        return $this->start_date ? date('Y/m/d', strtotime($this->start_date)) : '-';
    }

    public function showEndDate()
    {
        return $this->end_date ? date('Y/m/d', strtotime($this->end_date)) : '-';
    }
}
