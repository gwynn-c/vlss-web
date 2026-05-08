<?php

use App\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/about-us', [AboutUsController::class, 'index']);

Route::get('/careers', function () {
    return view('careers');
});

Route::get('/games', function () {
    return view('games');
});
