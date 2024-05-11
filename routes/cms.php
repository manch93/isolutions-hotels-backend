<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'cms',
    'as' => 'cms.',
    'middleware' => ['auth', 'validate-role-permission'],
], function () {

    Route::get('/', App\Livewire\Dashboard::class)->name('dashboard');

    // Front Desk
    Route::get('/front-desk', App\Livewire\FrontDesk::class)->name('front-desk');

    // Master Data
    Route::get('/master/hotel', App\Livewire\Cms\Master\Hotel::class)->name('master.hotel');
    Route::get('/master/room-type', App\Livewire\Cms\Master\RoomType::class)->name('master.room-type');
    Route::get('/master/room', App\Livewire\Cms\Master\Room::class)->name('master.room');

    // Hotel
    Route::get('/hotel/facility', App\Livewire\Cms\Hotel\Facility::class)->name('hotel.facility');
    Route::get('/hotel/around', App\Livewire\Cms\Hotel\Around::class)->name('hotel.around');
    Route::get('/hotel/event', App\Livewire\Cms\Hotel\Event::class)->name('hotel.event');
    Route::get('/hotel/promo', App\Livewire\Cms\Hotel\Promo::class)->name('hotel.promo');
    Route::get('/hotel/food-category', App\Livewire\Cms\Hotel\FoodCategory::class)->name('hotel.food-category');
    Route::get('/hotel/food', App\Livewire\Cms\Hotel\Food::class)->name('hotel.food');
    Route::get('/hotel/policy', App\Livewire\Cms\Hotel\Policy::class)->name('hotel.policy');
    Route::get('/hotel/wifi', App\Livewire\Cms\Hotel\Wifi::class)->name('hotel.wifi');

    // Hotel Enabled channel
    Route::get('/hotel/{id}/enable-channel', App\Livewire\Cms\Hotel\EnabledChannel::class)->name('hotel.enabled-channel');

    // Management
    Route::get('/management/menu', App\Livewire\Cms\Management\Menu::class)->name('management.menu');
    Route::get('/management/m3u-channel', App\Livewire\Cms\Management\M3uSource::class)->name('management.m3u-channel');
    Route::get('/management/m3u-channel/{source?}', App\Livewire\Cms\Management\M3uSourceChannel::class)->name('management.m3u-channel.detail');
    Route::get('/management/role', App\Livewire\Cms\Management\Role::class)->name('management.role');
    Route::get('/management/role-permission/{role?}', App\Livewire\Cms\Management\RolePermission::class)->name('management.role-permission');
    Route::get('/management/user', App\Livewire\Cms\Management\User::class)->name('management.user');
    Route::get('/management/website', App\Livewire\Cms\Management\Setting::class)->name('management.setting');
    Route::get('/management/access-control', App\Livewire\Cms\Management\AccessControl::class)->name('management.access-control');
    Route::get('/management/privacy-policy', App\Livewire\Cms\Management\PrivacyPolicy::class)->name('management.privacy-policy');
    Route::get('/management/terms-of-service', App\Livewire\Cms\Management\TermOfService::class)->name('management.term-of-service');
});
