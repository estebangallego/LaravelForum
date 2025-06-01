<?php

use App\Support\PostFixtures;
use Illuminate\Support\Facades\Route;

Route::get('/post-content', function () {
    return (new PostFixtures())->getFixtures()->random();
})->name('api.post-content');
