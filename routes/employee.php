<?php

declare(strict_types=1);

use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\LeaveController;
use App\Http\Controllers\Employee\LetterController;
use App\Http\Controllers\Employee\QualificationAttachmentController;
use App\Http\Controllers\Employee\QualificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('leave', LeaveController::class)->only(['index', 'store']);
    Route::resource('qualifications', QualificationController::class);
    Route::resource('letters', LetterController::class);

    Route::prefix('qualifications/{qualification}/attachments')
        ->name('qualifications.attachments.')
        ->group(function (): void {
            Route::post('/', [QualificationAttachmentController::class, 'store'])->name('store');
            Route::delete('{media}', [QualificationAttachmentController::class, 'destroy'])->name('destroy');
        });
});
