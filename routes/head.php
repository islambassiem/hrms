<?php

declare(strict_types=1);

use App\Enums\PermissionEnum;
use App\Http\Controllers\Head\DashboardController;
use App\Http\Controllers\Head\EmployeeController;
use App\Http\Controllers\Head\LeaveController;
use App\Http\Controllers\Head\ShortLeaveController;
use App\Http\Middleware\EnsureDepartmentHead;
use Illuminate\Support\Facades\Route;

Route::prefix('head')
    ->name('head.')
    ->middleware([
        'auth',
        'can:'.PermissionEnum::HEAD_PAGE->value,
        EnsureDepartmentHead::class,
    ])->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/{employeeId}', [EmployeeController::class, 'show'])
            ->whereNumber('employeeId')
            ->name('employees.show');
        Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/short-leaves', [ShortLeaveController::class, 'index'])->name('short-leaves.index');
    });
