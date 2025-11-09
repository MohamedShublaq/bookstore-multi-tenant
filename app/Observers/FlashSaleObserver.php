<?php

namespace App\Observers;

use App\Enums\DiscountStatus;
use App\Models\FlashSale;
use Carbon\Carbon;

class FlashSaleObserver
{
    public function creating(FlashSale $flashSale): void
    {
        if ($flashSale->isWithinDateRange()) {
            $flashSale->status = DiscountStatus::Active;
        }
    }

    public function updating(FlashSale $flashSale): void
    {
        $now = Carbon::now();

        if ($flashSale->isDirty('start_at') || $flashSale->isDirty('end_at')) {
            if ($flashSale->isWithinDateRange() && !$flashSale->isActive() && !$flashSale->isInactive()) {
                $flashSale->status = DiscountStatus::Active;
            }

            if ($now < $flashSale->start_at && !$flashSale->isScheduled() && !$flashSale->isInactive()) {
                $flashSale->status = DiscountStatus::Scheduled;
            }

            if ($now >= $flashSale->end_at && !$flashSale->isExpired()) {
                $flashSale->status = DiscountStatus::Expired;
            }
        }
    }
}
