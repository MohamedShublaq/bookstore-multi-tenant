<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

app(Schedule::class)->command('app:change-coupon-status')->timezone('Africa/Cairo')->daily();
app(Schedule::class)->command('app:change-flash-sale-status')->timezone('Africa/Cairo')->everyMinute();
