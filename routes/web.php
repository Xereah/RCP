<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('rcp-panel.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('work-sessions.index');
})->middleware(['auth', 'verified'])
  ->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
//użytkownicy
Route::get('/users', \App\Livewire\Users\Index::class)->name('users.index');
Route::get('/users/create', \App\Livewire\Users\Create::class)->name('users.create');
Route::get('/users/show/{user}', \App\Livewire\Users\Show::class)->name('users.show');
Route::get('/users/update/{user}', \App\Livewire\Users\Edit::class)->name('users.edit');

//role
Route::get('/roles', \App\Livewire\Roles\Index::class)->name('roles.index');
Route::get('/roles/create', \App\Livewire\Roles\Create::class)->name('roles.create');
Route::get('/roles/show/{role}', \App\Livewire\Roles\Show::class)->name('roles.show');
Route::get('/roles/update/{role}', \App\Livewire\Roles\Edit::class)->name('roles.edit');

//stanowiska
Route::get('/positions', \App\Livewire\Positions\Index::class)->name('positions.index');
Route::get('/positions/create', \App\Livewire\Positions\Create::class)->name('positions.create');
Route::get('/positions/show/{position}', \App\Livewire\Positions\Show::class)->name('positions.show');
Route::get('/positions/update/{position}', \App\Livewire\Positions\Edit::class)->name('positions.edit');

//pracownicy
Route::get('/personels', \App\Livewire\Personels\Index::class)->name('personels.index');
Route::get('/personels/create', \App\Livewire\Personels\Create::class)->name('personels.create');
Route::get('/personels/show/{personel}', \App\Livewire\Personels\Show::class)->name('personels.show');
Route::get('/personels/update/{personel}', \App\Livewire\Personels\Edit::class)->name('personels.edit');

//statusy obecnosci
Route::get('/work-statuses', \App\Livewire\WorkStatuses\Index::class)->name('work-statuses.index');
Route::get('/work-statuses/create', \App\Livewire\WorkStatuses\Create::class)->name('work-statuses.create');
Route::get('/work-statuses/show/{workStatus}', \App\Livewire\WorkStatuses\Show::class)->name('work-statuses.show');
Route::get('/work-statuses/update/{workStatus}', \App\Livewire\WorkStatuses\Edit::class)->name('work-statuses.edit');

//obecnosci
Route::get('/work-sessions', \App\Livewire\WorkSessions\Index::class)->name('work-sessions.index');
Route::get('/work-sessions/create', \App\Livewire\WorkSessions\Create::class)->name('work-sessions.create');
Route::get('/work-sessions/show/{workSession}', \App\Livewire\WorkSessions\Show::class)->name('work-sessions.show');
Route::get('/work-sessions/update/{workSession}', \App\Livewire\WorkSessions\Edit::class)->name('work-sessions.edit');

//panel RCP
Route::get('/rcp-panel', \App\Livewire\RCP\Index::class)->name('rcp-panel.index');

require __DIR__.'/auth.php';
