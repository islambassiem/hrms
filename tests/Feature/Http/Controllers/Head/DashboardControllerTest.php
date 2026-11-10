<?php

use App\Enums\PermissionEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\Gender;
use App\Models\Lookup\LeaveType;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

test('guests are redirected from the Department Head dashboard', function (): void {
    $this->get(route('head.dashboard'))
        ->assertRedirect(route('login'));
});

test('users without the Head permission cannot open the Department Head dashboard', function (): void {
    $employee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('head.dashboard'))
        ->assertForbidden();
});

test('department heads receive active direct subordinate summaries', function (): void {
    $male = Gender::factory()->create([
        'name_en' => 'Male',
        'name_ar' => 'ذكر',
        'code' => '1',
    ]);
    $female = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
        'code' => '2',
    ]);

    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $maleSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'gender_id' => $male->id,
        'is_active' => true,
    ]);
    $femaleSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'gender_id' => $female->id,
        'is_active' => true,
    ]);
    $inactiveSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'gender_id' => $male->id,
        'is_active' => false,
    ]);
    $unrelatedEmployee = Employee::factory()->create(['is_active' => true]);

    $leaveType = LeaveType::factory()->create();
    LeaveRequest::factory()->create([
        'employee_id' => $maleSubordinate->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $inactiveSubordinate->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $unrelatedEmployee->id,
        'leave_type_id' => $leaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $today = today();
    LeaveRequest::factory(2)->create([
        'employee_id' => $maleSubordinate->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => $today->copy()->subDay(),
        'end_date' => $today->copy()->addDay(),
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);
    LeaveRequest::factory()->create([
        'employee_id' => $femaleSubordinate->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => $today->copy()->subDays(3),
        'end_date' => $today->copy()->subDay(),
        'status' => WorkflowActionEnum::APPROVED->value,
    ]);

    $shortLeaveType = ShortLeaveType::factory()->create();
    ShortLeaveRequest::factory()->create([
        'employee_id' => $femaleSubordinate->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);
    ShortLeaveRequest::factory()->create([
        'employee_id' => $unrelatedEmployee->id,
        'short_leave_type_id' => $shortLeaveType->id,
        'status' => WorkflowActionEnum::PENDING->value,
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/dashboard')
            ->where('headDashboard', [
                'activeStaffCount' => 2,
                'maleStaffCount' => 1,
                'femaleStaffCount' => 1,
                'pendingRegularLeaveCount' => 1,
                'pendingShortLeaveCount' => 1,
                'employeesOnLeaveTodayCount' => 1,
            ]),
        );
});

test('department heads without an employee profile cannot open the dashboard', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.dashboard'))
        ->assertForbidden();
});

test('department heads with no active direct reports receive zero counts', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.dashboard'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/dashboard')
            ->where('headDashboard', [
                'activeStaffCount' => 0,
                'maleStaffCount' => 0,
                'femaleStaffCount' => 0,
                'pendingRegularLeaveCount' => 0,
                'pendingShortLeaveCount' => 0,
                'employeesOnLeaveTodayCount' => 0,
            ]),
        );
});
