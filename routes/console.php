<?php

use App\Http\Controllers\api\CardEndCoefficientController;
use App\Http\Controllers\api\DailyTestController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    (new CardEndCoefficientController())->updateEndCoefficient();
})->dailyAt('00:00'); // Runs at midnight
Schedule::call(function () {
    (new DailyTestController())->generateDailyTest();
})->dailyAt('00:01'); // Runs at midnight
//Schedule::call(function () {
//    (new CardEndCoefficientController())->updateEndCoefficient();
//})->everyMinute(); // test every minute
