<?php

use App\Enums\PermissionEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

beforeEach(function (): void {
    $this->withoutVite();
});

test('guests are redirected from the Department Head Leaves page', function (): void {
    $this->get(route('head.leaves.index'))
        ->assertRedirect(route('login'));
});

test('users without Head permission cannot view subordinate Leave requests', function (): void {
    $employee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('head.leaves.index'))
        ->assertForbidden();
});

test('department heads see only active direct reports and can filter Leave requests', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $inactiveSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => false,
    ]);
    $unrelatedEmployee = Employee::factory()->create(['is_active' => true]);

    $leaveType = LeaveType::factory()->create();
    $otherLeaveType = LeaveType::factory()->create();
    $olderRequest = LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => now()->subDay(),
    ]);
    $newerRequest = LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => now(),
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $otherLeaveType->id,
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $inactiveSubordinate->id,
        'leave_type_id' => $leaveType->id,
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $unrelatedEmployee->id,
        'leave_type_id' => $leaveType->id,
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.leaves.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/leaves/index', false)
            ->has('leaveRequests.data', 3)
            ->where('leaveRequests.data.0.id', $newerRequest->id)
            ->where('leaveRequests.data.2.id', $olderRequest->id)
            ->where('employees.0.id', $subordinate->id)
            ->missing('employees.1')
            ->where('statuses', ['pending', 'approved', 'rejected', 'cancelled']),
        );

    $this->get(route('head.leaves.index', [
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/leaves/index', false)
            ->has('leaveRequests.data', 2)
            ->where('filters.employeeId', $subordinate->id)
            ->where('filters.leaveTypeId', $leaveType->id)
            ->where('filters.status', WorkflowActionEnum::PENDING->value),
        );
});

test('a department head without an Employee profile cannot view the Leaves page', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.leaves.index'))
        ->assertForbidden();
});

test('department heads can filter Regular Leave by its date range', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $leaveType = LeaveType::factory()->create();

    $includedRequest = LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-11-04',
        'end_date' => '2026-11-06',
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-11-01',
        'end_date' => '2026-11-05',
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2026-11-05',
        'end_date' => '2026-11-10',
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.leaves.index', [
            'start_date' => '2026-11-03',
            'end_date' => '2026-11-07',
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/leaves/index', false)
            ->has('leaveRequests.data', 1)
            ->where('leaveRequests.data.0.id', $includedRequest->id),
        );
});

test('department head Regular Leave results paginate', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $leaveType = LeaveType::factory()->create();
    LeaveRequest::factory(16)->create([
        'employee_id' => $subordinate->id,
        'leave_type_id' => $leaveType->id,
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.leaves.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/leaves/index', false)
            ->has('leaveRequests.data', 15)
            ->where('leaveRequests.meta.total', 16)
            ->where('leaveRequests.meta.last_page', 2),
        );

    $this->get(route('head.leaves.index', ['page' => 2]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/leaves/index', false)
            ->has('leaveRequests.data', 1)
            ->where('leaveRequests.meta.current_page', 2),
        );
});

test('department head Regular Leave filters reject an inverted date range', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.leaves.index', [
            'start_date' => '2026-11-10',
            'end_date' => '2026-11-01',
        ]))
        ->assertSessionHasErrors('end_date');
});
