<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'docs',
    'as' => 'docs.',
    'middleware' => ['auth'],
], function () {

    Route::get('/{slug?}', App\Livewire\Docs\Index::class)->name('index');
});
