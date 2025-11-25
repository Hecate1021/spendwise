<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Example built-in command
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule your goal reminder command
$schedule = app(Illuminate\Console\Scheduling\Schedule::class);
$schedule->command('goals:send-reminders')->dailyAt('08:00'); // 8 AM Manila time
