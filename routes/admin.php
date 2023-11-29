<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => ['auth', 'role:admin'],
], function () {

    Route::get('/', App\Livewire\Dashboard::class)->name('dashboard');

    // Master Data
    Route::get('/master/hotel', App\Livewire\Cms\Master\Hotel::class)->name('master.hotel');
    Route::get('/master/room-type', App\Livewire\Cms\Master\RoomType::class)->name('master.room-type');
    Route::get('/master/room', App\Livewire\Cms\Master\Room::class)->name('master.room');

    // Hotel
    Route::get('/hotel/facility', App\Livewire\Cms\Hotel\Facility::class)->name('hotel.facility');

    // Management
    Route::get('/management/menu', App\Livewire\Cms\Management\Menu::class)->name('management.menu');
    Route::get('/management/role', App\Livewire\Cms\Management\Role::class)->name('management.role');
    Route::get('/management/user', App\Livewire\Cms\Management\User::class)->name('management.user');
    Route::get('/management/website', App\Livewire\Cms\Management\Setting::class)->name('management.setting');
    Route::get('/management/privacy-policy', App\Livewire\Cms\Management\PrivacyPolicy::class)->name('management.privacy-policy');
    Route::get('/management/terms-of-service', App\Livewire\Cms\Management\TermOfService::class)->name('management.term-of-service');
});
