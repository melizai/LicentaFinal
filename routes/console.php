<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('send-reminders', function () {
    Artisan::call('app:send-deadline-reminders');
})->purpose('Send email reminders for templates close to their deadline')->hourly();
