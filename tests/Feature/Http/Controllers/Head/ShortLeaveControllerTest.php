<?php

use App\Enums\PermissionEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

beforeEach(function (): void {
    $this->withoutVite();
});

test('guests are redirected from the Department Head Short Leaves page', function (): void {
    $this->get(route('head.short-leaves.index'))
        ->assertRedirect(route('login'));
});

test('users without Head permission cannot view subordinate Short Leave requests', function (): void {
    $employee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('head.short-leaves.index'))
        ->assertForbidden();
});

test('department heads see only active direct reports and can filter Short Leave dates', function (): void {
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

    $shortLeaveType = ShortLeaveType::factory()->create();
    $otherShortLeaveType = ShortLeaveType::factory()->create();
    $earlierRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'short_leave_date' => '2026-11-01',
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => now()->subDay(),
    ]);
    $laterRequest = ShortLeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'short_leave_date' => '2026-11-05',
        'status' => WorkflowActionEnum::PENDING->value,
        'created_at' => now(),
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $subordinate->id,
        'short_leave_type_id' => $otherShortLeaveType->id,
        'short_leave_date' => '2026-11-03',
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $inactiveSubordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'short_leave_date' => '2026-11-03',
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $unrelatedEmployee->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'short_leave_date' => '2026-11-03',
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.short-leaves.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/short-leaves/index', false)
            ->has('shortLeaveRequests.data', 3)
            ->where('shortLeaveRequests.data.0.id', $laterRequest->id)
            ->where('shortLeaveRequests.data.2.id', $earlierRequest->id)
            ->where('employees.0.id', $subordinate->id)
            ->missing('employees.1'),
        );

    $this->get(route('head.short-leaves.index', [
        'employee_id' => $subordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
        'from_date' => '2026-11-04',
        'to_date' => '2026-11-06',
    ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/short-leaves/index', false)
            ->has('shortLeaveRequests.data', 1)
            ->where('shortLeaveRequests.data.0.id', $laterRequest->id)
            ->where('shortLeaveRequests.data.0.date', '2026-11-05')
            ->where('filters.fromDate', '2026-11-04')
            ->where('filters.toDate', '2026-11-06'),
        );
});

test('a department head without an Employee profile cannot view the Short Leaves page', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.short-leaves.index'))
        ->assertForbidden();
});

test('department heads can filter Short Leave by employee and paginate the results', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $selectedSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $otherSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $shortLeaveType = ShortLeaveType::factory()->create();

    ShortLeaveRequest::factory(16)->create([
        'employee_id' => $selectedSubordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $otherSubordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.short-leaves.index', ['employee_id' => $selectedSubordinate->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/short-leaves/index', false)
            ->has('shortLeaveRequests.data', 15)
            ->where('shortLeaveRequests.meta.total', 16)
            ->where('shortLeaveRequests.meta.last_page', 2),
        );

    $this->get(route('head.short-leaves.index', [
        'employee_id' => $selectedSubordinate->id,
        'page' => 2,
    ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/short-leaves/index', false)
            ->has('shortLeaveRequests.data', 1)
            ->where('shortLeaveRequests.meta.current_page', 2),
        );
});

test('department head Short Leave filters reject an inverted date range', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.short-leaves.index', [
            'from_date' => '2026-11-10',
            'to_date' => '2026-11-01',
        ]))
        ->assertSessionHasErrors('to_date');
});
