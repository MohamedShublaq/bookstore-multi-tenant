<?php

namespace App\Console\Commands;

use App\Enums\DiscountStatus;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeCouponStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-coupon-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change coupon status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        Coupon::scheduled()
            ->where('start_date', '<=', $today)
            ->update(['status' => DiscountStatus::Active]);

        Coupon::active()
            ->where('end_date', '<=', $today)
            ->update(['status' => DiscountStatus::Expired]);
    }
}
