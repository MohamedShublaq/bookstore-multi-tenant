<?php

namespace App\Models;

use App\Enums\DiscountStatus;
use App\Enums\DiscountType;
use App\Models\Tenant\TenantModel;
use App\Observers\CouponObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CouponObserver::class])]
class Coupon extends TenantModel
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

    protected $casts = [
        'discount_type' => DiscountType::class,
        'status'        => DiscountStatus::class,
    ];

    public const DEFAULT_TYPE   = DiscountType::Percentage;
    public const DEFAULT_STATUS = DiscountStatus::Scheduled;

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

    public function active(): bool
    {
        return $this->status === DiscountStatus::Active;
    }

    public function inactive(): bool
    {
        return $this->status === DiscountStatus::Inactive;
    }

    public function scheduled(): bool
    {
        return $this->status === DiscountStatus::Scheduled;
    }

    public function expired(): bool
    {
        return $this->status === DiscountStatus::Expired;
    }

    public function showStatus()
    {
        return match ($this->status) {
            DiscountStatus::Active    => '<span class="badge badge-success">Active</span>',
            DiscountStatus::Inactive  => '<span class="badge badge-danger">Inactive</span>',
            DiscountStatus::Scheduled => '<span class="badge badge-warning">Scheduled</span>',
            DiscountStatus::Expired   => '<span class="badge badge-danger">Expired</span>',
            default                   => '<span class="badge badge-success">Active</span>',
        };
    }

    public function showStartDate()
    {
        return $this->start_date ? date('Y/m/d', strtotime($this->start_date)) : '-';
    }

    public function showEndDate()
    {
        return $this->end_date ? date('Y/m/d', strtotime($this->end_date)) : '-';
    }

    public function showDiscountValue()
    {
        $currency = app()->has('library') ? app('library')->currency : null;
        return match ($this->discount_type) {
            DiscountType::Percentage => $this->discount_value . '%',
            DiscountType::Fixed      => $this->discount_value . ' ' . $currency,
            default                  => $this->discount_value,
        };
    }

    public function showAppliesToAllBooks()
    {
        return $this->applies_to_all_books
            ? '<span class="badge badge-success">Yes</span>'
            : '<span class="badge badge-danger">No</span>';
    }
}
