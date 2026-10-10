<?php

namespace App\Http\Controllers\Employee;

use App\Http\Resources\Employee\DashboardResource;
use App\Http\Resources\Leave\DashboardLeaveRequestResource;
use App\Models\User;
use App\Queries\Leave\EmployeeDashboardLeaveRequestQuery;
use Carbon\CarbonImmutable;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController
{
    public function index(): Response
    {
        $user = request()->user();

        abort_unless($user instanceof User, 403);

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
        $employeeDashboard = DashboardResource::make($employee)->resolve(request());
        $employeeDashboard['pendingRegularLeaveRequests'] = DashboardLeaveRequestResource::collection(
            $pendingRegularLeaveRequests,
        )->resolve(request());
        $employeeDashboard['upcomingApprovedRegularLeave'] = $upcomingApprovedRegularLeave
            ? DashboardLeaveRequestResource::make($upcomingApprovedRegularLeave)->resolve(request())
            : null;

        return Inertia::render('dashboard', [
            'employeeDashboard' => $employeeDashboard,
        ]);
    }
}
