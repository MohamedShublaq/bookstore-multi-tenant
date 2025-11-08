<?php

namespace App\Models\Discount;

use App\Enums\DiscountStatus;
use App\Enums\DiscountType;
use App\Models\Tenant\TenantModel;

class DiscountModel extends TenantModel
{
    protected $casts = [
        'discount_type' => DiscountType::class,
        'status'        => DiscountStatus::class,
    ];

    public const DEFAULT_TYPE   = DiscountType::Percentage;
    public const DEFAULT_STATUS = DiscountStatus::Scheduled;

    public function scopeActive($query)
    {
        return $query->where('status', DiscountStatus::Active->value);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', DiscountStatus::Inactive->value);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', DiscountStatus::Scheduled->value);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', DiscountStatus::Expired->value);
    }

    public function isActive(): bool
    {
        return $this->status === DiscountStatus::Active;
    }

    public function isInactive(): bool
    {
        return $this->status === DiscountStatus::Inactive;
    }

    public function isScheduled(): bool
    {
        return $this->status === DiscountStatus::Scheduled;
    }

    public function isExpired(): bool
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
