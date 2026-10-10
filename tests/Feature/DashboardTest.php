<?php

use App\Enums\LeaveTypeEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\JobTitle;
use App\Models\Lookup\LeaveType;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function (): void {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users without an employee profile receive an unavailable dashboard', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('dashboard')
            ->where('employeeDashboard', null),
        );
});

test('authenticated employees receive only their dashboard resource', function (): void {
    $employee = Employee::factory()->create();
    $jobTitle = JobTitle::factory()->create();

    EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => $jobTitle->id,
        'end_date' => null,
    ]);

    LeaveType::factory()->create([
        'id' => (int) LeaveTypeEnum::ANNUAL->value,
    ]);

    LeaveBalance::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => (int) LeaveTypeEnum::ANNUAL->value,
        'available_days' => 18.5,
        'accrued_days' => 20,
        'used_days' => 1,
        'pending_days' => 0.5,
        'expiring_days' => 2,
        'next_expiry_date' => '2027-01-31',
    ]);

    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('dashboard')
            ->where('employeeDashboard.id', $employee->id)
            ->where('employeeDashboard.jobTitle', [
                'id' => $jobTitle->id,
                'name' => $jobTitle->name,
            ])
            ->where('employeeDashboard.annualLeaveBalance', [
                'availableDays' => 18.5,
                'accruedDays' => 20,
                'usedDays' => 1,
                'pendingDays' => 0.5,
                'expiringDays' => 2,
                'nextExpiryDate' => '2027-01-31',
            ]),
        );
});

test('authenticated employees receive unavailable Leave and document values when records are absent', function (): void {
    $employee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('dashboard')
            ->where('employeeDashboard.annualLeaveBalance', null)
            ->where('employeeDashboard.identifications', [])
            ->where('employeeDashboard.pendingRegularLeaveRequests', [])
            ->where('employeeDashboard.upcomingApprovedRegularLeave', null),
        );
});

test('authenticated employees receive only their Regular Leave dashboard requests', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    $today = now()->startOfDay();

    $olderPendingRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => $today->copy()->subDays(2),
    ]);

    $pendingRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => $today->copy()->subDay(),
    ]);

    $activeApprovedLeave = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => $today->copy()->subDay(),
        'end_date' => $today->copy()->addDay(),
        'no_of_days' => 3,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => $today->copy()->subDays(4),
        'end_date' => $today->copy()->subDay(),
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    LeaveRequest::factory()->create([
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('dashboard')
            ->where('employeeDashboard.pendingRegularLeaveRequests', [
                [
                    'id' => $pendingRequest->id,
                    'leaveType' => [
                        'id' => $leaveType->id,
                        'name' => $leaveType->name,
                    ],
                    'startDate' => $pendingRequest->start_date->toDateString(),
                    'endDate' => $pendingRequest->end_date->toDateString(),
                    'durationDays' => $pendingRequest->no_of_days,
                    'status' => WorkflowActionEnum::PENDING->value,
                    'submittedDate' => $pendingRequest->created_at->toDateString(),
                ],
                [
                    'id' => $olderPendingRequest->id,
                    'leaveType' => [
                        'id' => $leaveType->id,
                        'name' => $leaveType->name,
                    ],
                    'startDate' => $olderPendingRequest->start_date->toDateString(),
                    'endDate' => $olderPendingRequest->end_date->toDateString(),
                    'durationDays' => $olderPendingRequest->no_of_days,
                    'status' => WorkflowActionEnum::PENDING->value,
                    'submittedDate' => $olderPendingRequest->created_at->toDateString(),
                ],
            ])
            ->where('employeeDashboard.upcomingApprovedRegularLeave', [
                'id' => $activeApprovedLeave->id,
                'leaveType' => [
                    'id' => $leaveType->id,
                    'name' => $leaveType->name,
                ],
                'startDate' => $activeApprovedLeave->start_date->toDateString(),
                'endDate' => $activeApprovedLeave->end_date->toDateString(),
                'durationDays' => 3,
                'status' => WorkflowActionEnum::APPROVED->value,
                'submittedDate' => $activeApprovedLeave->created_at->toDateString(),
            ]),
        );
});
