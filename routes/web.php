<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/about-us', function () {
    return view('about');
});

Route::get('/careers', function () {
    return view('careers');
});

Route::get('/games', function () {
    return view('games');
});
