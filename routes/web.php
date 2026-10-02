<?php

declare(strict_types=1);

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('dashboard'))->name('dashboard');
});

Route::post('/locale/{locale}', [LanguageController::class, 'update'])->name('locale.update');

require __DIR__.'/settings.php';
require __DIR__.'/hr.php';
require __DIR__.'/head.php';
