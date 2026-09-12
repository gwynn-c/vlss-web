<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/privacy-policy', [SiteController::class, 'privacy'])->name('privacy');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'show'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
    });

    // Authenticated
    Route::middleware('auth')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Hero (single record)
        Route::get('hero', [HeroController::class, 'edit'])->name('hero.edit');
        Route::put('hero', [HeroController::class, 'update'])->name('hero.update');

        // Site settings (single record)
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // Generic list sections (games, team, quotes, services, pillars, roles)
        Route::get('sections/{section}', [SectionController::class, 'index'])->name('sections.index');
        Route::get('sections/{section}/new', [SectionController::class, 'create'])->name('sections.create');
        Route::post('sections/{section}', [SectionController::class, 'store'])->name('sections.store');
        Route::post('sections/{section}/reorder', [SectionController::class, 'reorder'])->name('sections.reorder');
        Route::get('sections/{section}/{id}', [SectionController::class, 'edit'])->name('sections.edit');
        Route::put('sections/{section}/{id}', [SectionController::class, 'update'])->name('sections.update');
        Route::delete('sections/{section}/{id}', [SectionController::class, 'destroy'])->name('sections.destroy');
    });
});
