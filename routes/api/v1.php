<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.v1.',
    'middleware' => ['api', 'auth.api-key'],
], function () {
    Route::get('/tv', [App\Http\Controllers\Api\V1\TvController::class, 'get'])->name('tv');
    Route::get('/hotel', [App\Http\Controllers\Api\V1\HotelController::class, 'get'])->name('hotel');
    Route::get('/facility', [App\Http\Controllers\Api\V1\HotelController::class, 'facility'])->name('facility');
    Route::get('/policy', [App\Http\Controllers\Api\V1\PolicyController::class, 'get'])->name('policy');
    Route::get('/promo', [App\Http\Controllers\Api\V1\PromoController::class, 'get'])->name('promo');
    Route::get('/food', [App\Http\Controllers\Api\V1\FoodController::class, 'get'])->name('food');
    Route::get('/around', [App\Http\Controllers\Api\V1\AroundController::class, 'get'])->name('around');
    Route::get('/room', [App\Http\Controllers\Api\V1\RoomController::class, 'get'])->name('room');
    Route::get('/room/{id}', [App\Http\Controllers\Api\V1\RoomController::class, 'detail'])->name('room.detail');
});
