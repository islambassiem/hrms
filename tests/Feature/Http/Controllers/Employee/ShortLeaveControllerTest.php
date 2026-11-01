<?php

declare(strict_types=1);

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function (): void {
    $this->withoutVite();

    /** @var object{employee: Employee, user: User} $this */
    $this->user = User::factory()->create();
    $this->employee = Employee::factory()->create([
        'user_id' => $this->user->id,
    ]);
});

test('guests are redirected from the Short Leave page', function (): void {
    $this->get(route('short-leaves.index'))
        ->assertRedirect(route('login'));
});

test('employees receive only their paginated Short Leave history', function (): void {
    $shortLeaveType = ShortLeaveType::factory()->create();
    $otherEmployee = Employee::factory()->create();
    $ownRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $otherEmployee->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('short-leaves.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/short-leave/index')
            ->where('initialForm.mode', null)
            ->where('initialForm.shortLeave', null)
            ->where('shortLeaveRequests.data.0.id', $ownRequest->id)
            ->where('shortLeaveRequests.data.0.canEdit', true)
            ->where('shortLeaveRequests.data.0.canDelete', true)
            ->has('shortLeaveRequests.data', 1)
            ->has('shortLeaveRequests.links')
            ->has('shortLeaveRequests.meta')
            ->has('shortLeaveTypes'),
        );
});

test('employees filter Short Leave history by date and type', function (): void {
    $matchingType = ShortLeaveType::factory()->create();
    $otherType = ShortLeaveType::factory()->create();
    $matchingRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_date' => '2026-10-15',
        'short_leave_type_id' => $matchingType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_date' => '2026-10-20',
        'short_leave_type_id' => $matchingType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_date' => '2026-10-15',
        'short_leave_type_id' => $otherType->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('short-leaves.index', [
            'from_date' => '2026-10-10',
            'short_leave_type_id' => $matchingType->id,
            'to_date' => '2026-10-18',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('filters', [
                'fromDate' => '2026-10-10',
                'shortLeaveTypeId' => $matchingType->id,
                'toDate' => '2026-10-18',
            ])
            ->where('shortLeaveRequests.data.0.id', $matchingRequest->id)
            ->has('shortLeaveRequests.data', 1),
        );
});

test('the create route opens the Short Leave create Sheet state', function (): void {
    ShortLeaveType::factory()->create();

    $this->actingAs($this->user)
        ->get(route('short-leaves.create'))
        ->assertRedirect(route('short-leaves.index', ['form' => 'create']));

    $this->actingAs($this->user)
        ->get(route('short-leaves.index', ['form' => 'create']))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('initialForm.mode', 'create')
            ->where('initialForm.shortLeave', null),
        );
});

test('employees see an unavailable Short Leave form state when no types are configured', function (): void {
    $this->actingAs($this->user)
        ->get(route('short-leaves.index', ['form' => 'create']))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('initialForm.mode', null)
            ->has('shortLeaveTypes', 0),
        );
});

test('employees submit browser date and time values for their own pending Short Leave request', function (): void {
    $shortLeaveType = ShortLeaveType::factory()->create();
    $otherEmployee = Employee::factory()->create();

    $this->actingAs($this->user)
        ->post(route('short-leaves.store'), [
            'employee_id' => $otherEmployee->id,
            'short_leave_date' => '2026-10-31',
            'short_leave_from' => '09:00',
            'short_leave_to' => '11:30',
            'short_leave_type_id' => $shortLeaveType->id,
            'status' => WorkflowActionEnum::APPROVED->value,
        ])
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success');

    $shortLeaveRequest = ShortLeaveRequest::query()->sole();

    expect($shortLeaveRequest->employee_id)->toBe($this->employee->id)
        ->and($shortLeaveRequest->short_leave_date->toDateString())
        ->toBe('2026-10-31')
        ->and($shortLeaveRequest->short_leave_from->format('H:i:s'))
        ->toBe('09:00:00')
        ->and($shortLeaveRequest->short_leave_to->format('H:i:s'))
        ->toBe('11:30:00')
        ->and($shortLeaveRequest->status)
        ->toBe(WorkflowActionEnum::PENDING->value);
});

test('employees can edit only pending Short Leave requests', function (): void {
    $shortLeaveType = ShortLeaveType::factory()->create();
    $pendingRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    $approvedRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    $this->actingAs($this->user)
        ->get(route('short-leaves.edit', $pendingRequest))
        ->assertRedirect(
            route('short-leaves.index', ['edit' => $pendingRequest->id]),
        );

    $this->actingAs($this->user)
        ->put(route('short-leaves.update', $pendingRequest), [
            'short_leave_date' => '2026-10-31',
            'short_leave_from' => '10:00',
            'short_leave_to' => '12:00',
            'short_leave_type_id' => $shortLeaveType->id,
            'status' => WorkflowActionEnum::APPROVED->value,
        ])
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success');

    expect($pendingRequest->refresh()->status)
        ->toBe(WorkflowActionEnum::PENDING->value)
        ->and($pendingRequest->short_leave_from->format('H:i:s'))
        ->toBe('10:00:00');

    $this->actingAs($this->user)
        ->put(route('short-leaves.update', $approvedRequest), [
            'short_leave_date' => '2026-10-31',
            'short_leave_from' => '10:00',
            'short_leave_to' => '12:00',
            'short_leave_type_id' => $shortLeaveType->id,
        ])
        ->assertForbidden();
});

test('employees can delete only Short Leave requests that are not approved', function (): void {
    $rejectedRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => WorkflowActionEnum::REJECTED->value,
    ]);
    $approvedRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $this->employee->id,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    $this->actingAs($this->user)
        ->delete(route('short-leaves.destroy', $rejectedRequest))
        ->assertRedirectBack()
        ->assertInertiaFlash('toast.type', 'success');

    expect(ShortLeaveRequest::query()->find($rejectedRequest->id))->toBeNull();

    $this->actingAs($this->user)
        ->delete(route('short-leaves.destroy', $approvedRequest))
        ->assertForbidden();
});

test('employees cannot access another employee Short Leave request', function (): void {
    $otherRequest = ShortLeaveRequest::factory()->create();

    $this->actingAs($this->user)
        ->get(route('short-leaves.edit', $otherRequest))
        ->assertForbidden();
});
