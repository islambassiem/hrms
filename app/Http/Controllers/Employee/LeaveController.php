<?php

namespace App\Http\Controllers\Employee;

use App\Actions\Leave\LeaveRequestCreateAction;
use App\Actions\Leave\LeaveRequestDeleteAction;
use App\Data\Leave\LeaveRequestData;
use App\Data\Leave\LeaveRequestFiltersData;
use App\Enums\WorkflowActionEnum;
use App\Http\Requests\Employee\Leave\StoreLeaveRequest;
use App\Http\Resources\Employee\LeavePageEmployeeResource;
use App\Http\Resources\Leave\EmployeeLeaveRequestResource;
use App\Http\Resources\Leave\LeaveTypeOptionResource;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use App\Queries\Leave\EmployeeDashboardLeaveRequestQuery;
use App\Queries\Leave\LeaveRequestQuery;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LeaveController
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        $employee = $user->employee()
            ->with([
                'latestCurrentJobTitle.jobTitle',
                'department',
                'annualLeaveBalance',
            ])
            ->first();

        if (! $employee instanceof Employee) {
            return Inertia::render('employee/leave/index', [
                'leavePage' => null,
            ]);
        }

        $regularLeaveRequests = (new LeaveRequestQuery(
            new LeaveRequestFiltersData(employeeIds: [$employee->id]),
        ))->run()
            ->with(['leaveType', 'media'])
            ->get();

        $upcomingApprovedLeave = (new EmployeeDashboardLeaveRequestQuery(
            $employee,
            CarbonImmutable::today(),
        ))->ongoingOrUpcomingApproved()
            ->with(['leaveType', 'media'])
            ->first();

        $pendingRegularLeaveCount = $regularLeaveRequests
            ->where('status', WorkflowActionEnum::PENDING->value)
            ->count();

        $pendingShortLeaveCount = ShortLeaveRequest::query()
            ->where('employee_id', $employee->id)
            ->where('status', WorkflowActionEnum::PENDING->value)
            ->count();

        /** @var array<string, mixed> $employeeData */
        $employeeData = LeavePageEmployeeResource::make($employee)->resolve($request);

        return Inertia::render('employee/leave/index', [
            'leavePage' => [
                ...$employeeData,
                'sickLeave' => null,
                'recentUpdates' => null,
                'pendingCounts' => [
                    'regularCount' => $pendingRegularLeaveCount,
                    'shortCount' => $pendingShortLeaveCount,
                    'totalCount' => $pendingRegularLeaveCount + $pendingShortLeaveCount,
                ],
                'upcomingApprovedLeave' => $upcomingApprovedLeave instanceof LeaveRequest
                    ? EmployeeLeaveRequestResource::make($upcomingApprovedLeave)->resolve($request)
                    : null,
                'regularRequests' => EmployeeLeaveRequestResource::collection(
                    $regularLeaveRequests,
                )->resolve($request),
                'leaveTypes' => LeaveTypeOptionResource::collection(
                    LeaveType::query()
                        ->orderBy('sort_order')
                        ->orderBy('id')
                        ->get(),
                )->resolve($request),
            ],
        ]);
    }

    public function store(StoreLeaveRequest $request): RedirectResponse
    {
        $data = LeaveRequestData::from($request);

        resolve(LeaveRequestCreateAction::class)->handle($data, $request->file('attachments'));

        return to_route('leave.index')
            ->with('success', __('You applied for a leave successfully'));
    }

    public function destroy(LeaveRequest $leave): Response
    {
        resolve(LeaveRequestDeleteAction::class)->handle($leave);

        return Inertia::flash('success', __('You deleted the leave successfully'))
            ->render('employee/leave/index');
    }
}
