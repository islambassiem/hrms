<?php

declare(strict_types=1);

use App\Enums\WorkflowActionEnum;
use App\Http\Resources\Employee\ShortLeaveRequestResource;
use App\Models\Employee\Employee;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;

it('serializes the Short Leave fields required by the Employee interface', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['user_id' => $user->id]);
    $shortLeaveRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'short_leave_date' => '2026-10-31',
        'short_leave_from' => '09:00:00',
        'short_leave_to' => '11:30:00',
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    $request = Request::create('/short-leaves');
    $request->setUserResolver(static fn (): User => $user);

    $resource = ShortLeaveRequestResource::make(
        $shortLeaveRequest->load('shortLeaveType'),
    )->resolve($request);

    expect($resource)->toMatchArray([
        'canDelete' => true,
        'canEdit' => true,
        'id' => $shortLeaveRequest->id,
        'shortLeaveDate' => '2026-10-31',
        'shortLeaveFrom' => '09:00',
        'shortLeaveTo' => '11:30',
        'status' => WorkflowActionEnum::PENDING->value,
    ])
        ->and($resource['shortLeaveType'])->toMatchArray([
            'id' => $shortLeaveRequest->short_leave_type_id,
            'name' => $shortLeaveRequest->shortLeaveType->name,
        ]);
});

it('does not expose mutation controls for an approved Short Leave request', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['user_id' => $user->id]);
    $shortLeaveRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);
    $request = Request::create('/short-leaves');
    $request->setUserResolver(static fn (): User => $user);

    $resource = ShortLeaveRequestResource::make(
        $shortLeaveRequest->load('shortLeaveType'),
    )->resolve($request);

    expect($resource['canDelete'])->toBeFalse()
        ->and($resource['canEdit'])->toBeFalse();
});
