<?php

namespace App\Observers;

use App\Enums\DiscountStatus;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponObserver
{
    public function creating(Coupon $coupon): void
    {
        $this->handleDates($coupon);
        if ($coupon->hasNoDates() || $coupon->isWithinDateRange()) {
            $coupon->status = DiscountStatus::Active;
        }
    }

    public function updating(Coupon $coupon): void
    {
        $this->handleDates($coupon);

        if ($coupon->hasNoDates() && !$coupon->active()) {
            $coupon->status = DiscountStatus::Active;
            return;
        }

        $today = Carbon::today();

        if ($coupon->isDirty('start_date') || $coupon->isDirty('end_date')) {
            if ($coupon->isWithinDateRange() && !$coupon->active() && !$coupon->inactive()) {
                $coupon->status = DiscountStatus::Active;
            }

            if ($today < $coupon->start_date && !$coupon->scheduled() && !$coupon->inactive()) {
                $coupon->status = DiscountStatus::Scheduled;
            }

            if ($today >= $coupon->end_date && !$coupon->expired()) {
                $coupon->status = DiscountStatus::Expired;
            }
        }
    }

    private function handleDates(Coupon $coupon)
    {
        $coupon->start_date = $coupon->start_date ?: null;
        $coupon->end_date = $coupon->end_date ?: null;
    }
}
