<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
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

require __DIR__.'/auth.php';
