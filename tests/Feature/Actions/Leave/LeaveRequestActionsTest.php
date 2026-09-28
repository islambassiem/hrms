<?php

declare(strict_types=1);

use App\Actions\Leave\LeaveRequestCreateAction;
use App\Actions\Leave\LeaveRequestUpdateAction;
use App\Data\Leave\LeaveRequestData;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

it('creates and updates a leave request', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    $request = (new LeaveRequestCreateAction)->handle(new LeaveRequestData($leaveType->id, $employee->id, CarbonImmutable::parse('2026-10-01'), CarbonImmutable::parse('2026-10-03')));
    $updated = (new LeaveRequestUpdateAction)->handle($request, new LeaveRequestData($leaveType->id, $employee->id, CarbonImmutable::parse('2026-10-02'), CarbonImmutable::parse('2026-10-05'), 'approved', 'Approved request'));

    expect($request)->toBeInstanceOf(LeaveRequest::class)
        ->and($updated)->toBeInstanceOf(LeaveRequest::class)
        ->and($updated->status)->toBe('approved');
});

it('creates a valid leave request', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();

    $request = resolve(LeaveRequestCreateAction::class)
        ->handle(LeaveRequestData::from(LeaveRequest::factory()->make([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'status' => WorkflowActionEnum::PENDING->value,
        ])));

    expect($request)->toBeInstanceOf(LeaveRequest::class);
    expect($request->status)->toBe('pending');
    $this->assertDatabaseHas('leave_requests', [
        'id' => $request->id,
        'employee_id' => $request->employee_id,
        'leave_type_id' => $request->leave_type_id,
        'status' => $request->status,
        'no_of_days' => $request->start_date->diffInDays($request->end_date) + 1,
    ]);
});

it('rejects a leave request with an invalid date range', function (): void {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    (new LeaveRequestCreateAction)->handle(new LeaveRequestData($leaveType->id, $employee->id, CarbonImmutable::parse('2026-10-04'), CarbonImmutable::parse('2026-10-03')));
})->throws(ValidationException::class);
