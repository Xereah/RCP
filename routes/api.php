<?php

declare(strict_types=1);

use App\Http\Controllers\Api\WorkSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Tutaj możesz rejestrować trasy API dla swojej aplikacji. Te trasy
| są ładowane przez RouteServiceProvider w grupie middleware "api".
|
*/

// Endpointy dla obecności pracowników
Route::prefix('work-sessions')->group(function (): void {
    // GET /api/work-sessions/by-date?date=2025-11-29
    Route::get('by-date', [WorkSessionController::class, 'getByDate'])
        ->name('api.work-sessions.by-date');

    // GET /api/work-sessions/by-date-range?date_from=2025-11-01&date_to=2025-11-30
    Route::get('by-date-range', [WorkSessionController::class, 'getByDateRange'])
        ->name('api.work-sessions.by-date-range');

    // GET /api/work-sessions/statistics?date=2025-11-29
    Route::get('statistics', [WorkSessionController::class, 'getStatistics'])
        ->name('api.work-sessions.statistics');

    // GET /api/work-sessions/{workSession}
    Route::get('{workSession}', [WorkSessionController::class, 'show'])
        ->name('api.work-sessions.show');
});

