<?php

declare(strict_types=1);

use App\Enums\PermissionEnum;
use App\Http\Controllers\HR\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('hr')
    ->name('hr.')
    ->middleware(['auth', 'can:'.PermissionEnum::HR_PAGE->value])
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
