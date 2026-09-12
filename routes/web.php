<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

// The contact form posts to "/" (handled here) so it works on nginx hosts
// that have no Laravel front-controller rewrite for deep paths.
Route::post('/', [ContactController::class, 'store'])->name('contact.store');
