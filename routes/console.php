<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Harmonogram zadań
Schedule::command('work:fill-absences')
    ->dailyAt('00:00')
    ->timezone('Europe/Warsaw')
    ->runInBackground()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Komenda work:fill-absences zakończona sukcesem');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('Komenda work:fill-absences zakończona niepowodzeniem');
    });

# Uzupełnij nieobecności dla wczorajszego dnia
# php artisan work:fill-absences

# Uzupełnij nieobecności dla konkretnej daty
# php artisan work:fill-absences --date=2025-11-18