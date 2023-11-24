<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.v1',
], function () {
    Route::get('/tv', [App\Http\Controllers\Api\V1\TvController::class, 'get'])->name('tv');
});
