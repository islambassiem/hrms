<?php

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use App\Queries\Leave\EmployeeDashboardLeaveRequestQuery;
use Carbon\CarbonImmutable;

it('returns an employees pending Regular Leave requests in reverse chronological order', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();

    $olderRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => '2026-10-07 09:00:00',
    ]);

    $newerRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => '2026-10-08 09:00:00',
    ]);

    LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    LeaveRequest::factory()->create([
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $requests = (new EmployeeDashboardLeaveRequestQuery(
        $employee,
        CarbonImmutable::parse('2026-10-09'),
    ))->pending()->get();

    expect($requests->pluck('id')->all())
        ->toBe([$newerRequest->id, $olderRequest->id])
        ->and($requests->every(fn (LeaveRequest $request): bool => $request->relationLoaded('leaveType')))
        ->toBeTrue();
});

it('returns active and future approved Regular Leave chronologically', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();

    $activeLeave = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-10-08',
        'end_date' => '2026-10-10',
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    $futureLeave = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-10-12',
        'end_date' => '2026-10-14',
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-10-04',
        'end_date' => '2026-10-08',
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-10-12',
        'end_date' => '2026-10-14',
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $requests = (new EmployeeDashboardLeaveRequestQuery(
        $employee,
        CarbonImmutable::parse('2026-10-09'),
    ))->ongoingOrUpcomingApproved()->get();

    expect($requests->pluck('id')->all())
        ->toBe([$activeLeave->id, $futureLeave->id]);
});
