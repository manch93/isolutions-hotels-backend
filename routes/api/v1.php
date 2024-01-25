<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.v1',
    'middleware' => ['api', 'auth.api-key'],
], function () {
    Route::get('/tv', [App\Http\Controllers\Api\V1\TvController::class, 'get'])->name('tv');
});
