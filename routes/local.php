<?php

use Illuminate\Support\Facades\Route;
use App\Support\PostFixtures;

Route::middleware('api')->group(function () {
    Route::get('post-content', function () {
        return (new PostFixtures())->getFixtures()->random();
    })->name('api.post-content');
});

Route::middleware('web')->group(function () {
    // Web routes here
});
