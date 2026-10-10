<?php

use App\Enums\WorkflowActionEnum;
use App\Http\Resources\Leave\DashboardLeaveRequestResource;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;

it('maps the approved dashboard Leave request contract', function (): void {
    $leaveType = LeaveType::factory()->create();
    $leaveRequest = LeaveRequest::factory()->create([
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-10-12',
        'end_date' => '2026-10-14',
        'no_of_days' => 3,
        'status' => WorkflowActionEnum::APPROVED->value,
        'created_at' => '2026-10-01 09:00:00',
    ]);

    $result = DashboardLeaveRequestResource::make(
        $leaveRequest->load('leaveType'),
    )->resolve(request());

    expect($result)->toBe([
        'id' => $leaveRequest->id,
        'leaveType' => [
            'id' => $leaveType->id,
            'name' => $leaveType->name,
        ],
        'startDate' => '2026-10-12',
        'endDate' => '2026-10-14',
        'durationDays' => 3,
        'status' => WorkflowActionEnum::APPROVED->value,
        'submittedDate' => '2026-10-01',
    ]);
});
