<?php

declare(strict_types=1);

use App\Data\ShortLeave\ShortLeaveRequestFiltersData;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Queries\ShortLeave\ShortLeaveRequestQuery;

it('returns only the authenticated employee Short Leave requests in reverse chronological order', function (): void {
    $employee = Employee::factory()->create();
    $otherEmployee = Employee::factory()->create();
    $shortLeaveType = ShortLeaveType::factory()->create();

    $olderRequest = ShortLeaveRequest::factory()->create([
        'created_at' => '2026-10-01 09:00:00',
        'employee_id' => $employee->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);
    $latestRequest = ShortLeaveRequest::factory()->create([
        'created_at' => '2026-10-02 09:00:00',
        'employee_id' => $employee->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $otherEmployee->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);

    $requests = (new ShortLeaveRequestQuery(
        new ShortLeaveRequestFiltersData(employeeId: $employee->id),
    ))->run()->get();

    expect($requests->modelKeys())->toBe([
        $latestRequest->id,
        $olderRequest->id,
    ]);
});

it('filters an employee Short Leave history by type and date range', function (): void {
    $employee = Employee::factory()->create();
    $matchingType = ShortLeaveType::factory()->create();
    $otherType = ShortLeaveType::factory()->create();

    $matchingRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'short_leave_date' => '2026-10-15',
        'short_leave_type_id' => $matchingType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'short_leave_date' => '2026-10-20',
        'short_leave_type_id' => $matchingType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'short_leave_date' => '2026-10-15',
        'short_leave_type_id' => $otherType->id,
    ]);

    $requests = (new ShortLeaveRequestQuery(
        ShortLeaveRequestFiltersData::from([
            'employeeId' => $employee->id,
            'fromDate' => '2026-10-10',
            'shortLeaveTypeId' => $matchingType->id,
            'toDate' => '2026-10-18',
        ]),
    ))->run()->get();

    expect($requests->modelKeys())->toBe([$matchingRequest->id])
        ->and($requests->first()?->relationLoaded('shortLeaveType'))->toBeTrue();
});
