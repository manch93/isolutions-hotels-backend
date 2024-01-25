<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.v1',
    'middleware' => ['api', 'auth.api-key'],
], function () {
    Route::get('/tv', [App\Http\Controllers\Api\V1\TvController::class, 'get'])->name('tv');
    Route::get('/hotel', [App\Http\Controllers\Api\V1\HotelController::class, 'get'])->name('hotel');
    Route::get('/promo', [App\Http\Controllers\Api\V1\PromoController::class, 'get'])->name('promo');
    Route::get('/room', [App\Http\Controllers\Api\V1\RoomController::class, 'get'])->name('room');
    Route::get('/room/{id}', [App\Http\Controllers\Api\V1\RoomController::class, 'detail'])->name('room.detail');
});
