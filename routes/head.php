<?php

declare(strict_types=1);

use App\Http\Controllers\Head\DashboardController;
use App\Http\Controllers\Head\LeaveController;
use App\Http\Controllers\Head\ShortLeaveController;
use Illuminate\Support\Facades\Route;

Route::prefix('head')->name('head.')->middleware('auth')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/short-leaves', [ShortLeaveController::class, 'index'])->name('short-leaves.index');
});
