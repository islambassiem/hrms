<?php

use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;

it('belongs to its leave type', function (): void {
    $leaveType = LeaveType::factory()->create();

    $leaveRequest = LeaveRequest::factory()->create([
        'leave_type_id' => $leaveType->id,
    ]);

    expect($leaveRequest->leaveType->is($leaveType))
        ->toBeTrue();
});
