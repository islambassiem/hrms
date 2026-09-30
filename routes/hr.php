<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('hr')->name('hr.')->middleware('auth')->group(function (): void {
    Route::get('/', fn () => Inertia::render('hr/dashboard'))->name('dashboard');
});
