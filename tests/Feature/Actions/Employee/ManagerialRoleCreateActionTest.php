<?php

declare(strict_types=1);

use App\Actions\Employee\ManagerialRoleCreateAction;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeManagerialRole;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates a managerial role assignment with authenticated user audit fields', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $this->actingAs($user);

    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->make([
        'employee_id' => $employee->id,
    ]));

    $action = new ManagerialRoleCreateAction;
    $managerialRole = $action->handle($data);

    expect($managerialRole)->toBeInstanceOf(EmployeeManagerialRole::class);

    $this->assertDatabaseHas('employee_managerial_roles', [
        'id' => $managerialRole->id,
        'employee_id' => $employee->id,
        'managerial_role_id' => $data->managerial_role_id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when non-existent employee_id is provided', function (): void {
    $data = ManagerialRoleData::from([
        'employee_id' => 99999,
        'managerial_role_id' => 1,
        'start_date' => now(),
    ]);

    $action = new ManagerialRoleCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when end_date is before start_date', function (): void {
    $employee = Employee::factory()->create();

    $data = ManagerialRoleData::from([
        'employee_id' => $employee->id,
        'managerial_role_id' => 1,
        'start_date' => now(),
        'end_date' => now()->subDay(),
    ]);

    $action = new ManagerialRoleCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);
