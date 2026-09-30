<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('head')->name('head.')->middleware('auth')->group(function (): void {
    Route::get('/', fn () => Inertia::render('head/dashboard'))->name('dashboard');
});
