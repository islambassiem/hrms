<?php

declare(strict_types=1);

use App\Http\Controllers\LanguageController;
use App\Http\Resources\Employee\DashboardResource;
use App\Http\Resources\Leave\DashboardLeaveRequestResource;
use App\Models\User;
use App\Queries\Leave\EmployeeDashboardLeaveRequestQuery;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', function (Request $request) {
        $user = $request->user();

        if (! $user instanceof User) {
            abort(403);
        }

        $employee = $user->employee()
            ->with([
                'latestCurrentJobTitle.jobTitle',
                'department',
                'head',
                'annualLeaveBalance',
                'latestContract',
                'identifications.type',
            ])
            ->first();

        if ($employee === null) {
            return Inertia::render('dashboard', [
                'employeeDashboard' => null,
            ]);
        }

        $leaveRequestQuery = new EmployeeDashboardLeaveRequestQuery(
            $employee,
            CarbonImmutable::today(),
        );

        $pendingRegularLeaveRequests = $leaveRequestQuery->pending()->get();
        $upcomingApprovedRegularLeave = $leaveRequestQuery
            ->ongoingOrUpcomingApproved()
            ->first();

        /** @var array<string, mixed> $employeeDashboard */
        $employeeDashboard = DashboardResource::make($employee)->resolve($request);
        $employeeDashboard['pendingRegularLeaveRequests'] = DashboardLeaveRequestResource::collection(
            $pendingRegularLeaveRequests,
        )->resolve($request);
        $employeeDashboard['upcomingApprovedRegularLeave'] = $upcomingApprovedRegularLeave
            ? DashboardLeaveRequestResource::make($upcomingApprovedRegularLeave)->resolve($request)
            : null;

        return Inertia::render('dashboard', [
            'employeeDashboard' => $employeeDashboard,
        ]);
    })->name('dashboard');
});

Route::post('/locale/{locale}', [LanguageController::class, 'update'])->name('locale.update');

require __DIR__.'/settings.php';
require __DIR__.'/hr.php';
require __DIR__.'/head.php';
