<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    // 'middleware' => ['auth', 'role:receptionist'],
    'middleware' => ['auth', 'role:admin'],
], function () {

    Route::get('/', App\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/front-desk', App\Livewire\FrontDesk::class)->name('front-desk');
});
