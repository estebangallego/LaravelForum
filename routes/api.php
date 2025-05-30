<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Support\PostFixtures;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/post-content', function () {
    return (new PostFixtures())->getFixtures()->random();
})->name('api.post-content');
