<?php

declare(strict_types=1);

use App\Enums\LeaveTypeEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected from the Employee Leave page', function (): void {
    $this->get(route('leave.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users without an employee profile receive an unavailable Leave page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('leave.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/leave/index')
            ->where('leavePage', null),
        );
});

test('users without an employee profile cannot submit a Leave request', function (): void {
    $user = User::factory()->create();
    $leaveType = LeaveType::factory()->create();

    $this->actingAs($user)
        ->post(route('leave.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-12',
        ])
        ->assertForbidden();
});

test('employees receive only their database-backed Leave page data', function (): void {
    $employee = Employee::factory()->create();
    $otherEmployee = Employee::factory()->create();
    $annualLeaveType = LeaveType::factory()->create([
        'id' => (int) LeaveTypeEnum::ANNUAL->value,
        'sort_order' => 1,
    ]);
    $otherLeaveType = LeaveType::factory()->create(['sort_order' => 2]);

    LeaveBalance::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $annualLeaveType->id,
        'available_days' => 18,
        'accrued_days' => 24,
        'used_days' => 4,
        'pending_days' => 2,
        'expiring_days' => 0,
        'next_expiry_date' => null,
    ]);

    $latestRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $annualLeaveType->id,
        'start_date' => '2026-11-10',
        'end_date' => '2026-11-12',
        'no_of_days' => 3,
        'status' => WorkflowActionEnum::PENDING->value,
        'reason' => 'Family commitment',
        'created_at' => '2026-10-12 09:00:00',
    ]);

    $upcomingApprovedRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $otherLeaveType->id,
        'status' => WorkflowActionEnum::APPROVED->value,
        'start_date' => CarbonImmutable::today()->addDays(5)->toDateString(),
        'end_date' => CarbonImmutable::today()->addDays(7)->toDateString(),
        'no_of_days' => 3,
        'created_at' => '2026-10-10 09:00:00',
    ]);

    LeaveRequest::factory()->create([
        'employee_id' => $otherEmployee->id,
        'leave_type_id' => $otherLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $expectedLeaveTypes = LeaveType::query()
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get()
        ->map(static fn (LeaveType $leaveType): array => [
            'id' => $leaveType->id,
            'label' => $leaveType->name,
            'description' => $leaveType->description,
        ])
        ->values()
        ->all();

    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('leave.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/leave/index')
            ->where('leavePage.employee.name', $employee->name)
            ->where('leavePage.employee.employeeCode', $employee->employee_code)
            ->where('leavePage.annualLeave', [
                'availableDays' => 18,
                'accruedDays' => 24,
                'usedDays' => 4,
                'pendingDays' => 2,
                'expiringDays' => 0,
                'expiryDate' => null,
            ])
            ->where('leavePage.sickLeave', null)
            ->where('leavePage.recentUpdates', null)
            ->where('leavePage.upcomingApprovedLeave', [
                'id' => $upcomingApprovedRequest->id,
                'leaveType' => [
                    'id' => $otherLeaveType->id,
                    'name' => $otherLeaveType->name,
                ],
                'startDate' => CarbonImmutable::today()->addDays(5)->toDateString(),
                'endDate' => CarbonImmutable::today()->addDays(7)->toDateString(),
                'durationDays' => 3,
                'status' => WorkflowActionEnum::APPROVED->value,
                'submittedDate' => '2026-10-10',
                'reason' => $upcomingApprovedRequest->reason,
                'attachments' => [],
                'approvalTimeline' => null,
                'canCancel' => false,
            ])
            ->where('leavePage.pendingCounts', [
                'regularCount' => 1,
                'shortCount' => 1,
                'totalCount' => 2,
            ])
            ->where('leavePage.regularRequests.0', [
                'id' => $latestRequest->id,
                'leaveType' => [
                    'id' => $annualLeaveType->id,
                    'name' => $annualLeaveType->name,
                ],
                'startDate' => '2026-11-10',
                'endDate' => '2026-11-12',
                'durationDays' => 3,
                'status' => WorkflowActionEnum::PENDING->value,
                'submittedDate' => '2026-10-12',
                'reason' => 'Family commitment',
                'attachments' => [],
                'approvalTimeline' => null,
                'canCancel' => false,
            ])
            ->has('leavePage.regularRequests', 2)
            ->where('leavePage.leaveTypes', $expectedLeaveTypes),
        );
});

test('employees submit an attachment through their authenticated Leave request', function (): void {
    Storage::fake('public');

    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    $otherEmployee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->post(route('leave.store'), [
            'employee_id' => $otherEmployee->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-12',
            'status' => WorkflowActionEnum::APPROVED->value,
            'reason' => 'Medical appointment',
            'attachments' => UploadedFile::fake()->create(
                'medical-certificate.pdf',
                128,
                'application/pdf',
            ),
        ])
        ->assertRedirect(route('leave.index'));

    $leaveRequest = LeaveRequest::query()
        ->where('employee_id', $employee->id)
        ->where('leave_type_id', $leaveType->id)
        ->sole();

    expect($leaveRequest->reason)->toBe('Medical appointment');
    expect($leaveRequest->no_of_days)->toBe(3);
    expect($leaveRequest->status)->toBe(WorkflowActionEnum::PENDING->value);
    expect($leaveRequest->getMedia())->toHaveCount(1);
    expect($leaveRequest->getFirstMedia()?->file_name)
        ->toBe('medical-certificate.pdf');

    $this->actingAs($user)
        ->get(route('leave.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where(
                'leavePage.regularRequests.0.attachments.0.name',
                'medical-certificate.pdf',
            ),
        );
});

test('employees receive attachment validation errors before a Leave request is persisted', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->from(route('leave.index'))
        ->post(route('leave.store'), [
            'leave_type_id' => $leaveType->id,
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-12',
            'attachments' => UploadedFile::fake()->create(
                'leave-notes.txt',
                128,
                'text/plain',
            ),
        ])
        ->assertRedirect(route('leave.index'))
        ->assertSessionHasErrors('attachments');

    expect(LeaveRequest::query()->where('employee_id', $employee->id)->exists())
        ->toBeFalse();
});
