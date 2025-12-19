<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


app(Schedule::class)
    ->command('app:check-contracts')
    ->everyMinute()->appendOutputTo(storage_path('logs/contracts-schedule.log'));;
