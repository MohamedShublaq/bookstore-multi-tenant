<?php

namespace App\Console\Commands;

use App\Enums\DiscountStatus;
use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeFlashSaleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-flash-sale-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change flash sale status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        FlashSale::scheduled()
            ->where('start_at', '<=', $now)
            ->update(['status' => DiscountStatus::Active]);

        FlashSale::active()
            ->where('end_at', '<=', $now)
            ->update(['status' => DiscountStatus::Expired]);
    }
}
