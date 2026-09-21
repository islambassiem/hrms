<?php

declare(strict_types=1);

use App\Actions\Employee\ManagerialRoleCreateAction;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeManagerialRole;

it('creates a managerial role', function (): void {
    $employee = Employee::factory()->create();
    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->make([
        'employee_id' => $employee->id,
    ]));
    $managerialRole = resolve(ManagerialRoleCreateAction::class)->handle($data);

    expect($managerialRole)->toBeInstanceOf(EmployeeManagerialRole::class);
    $this->assertDatabaseHas('employee_managerial_roles', $managerialRole->getAttributes());
});

it('fails to create a job title assignment for non employee', function (): void {
    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->make([
        'employee_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(ManagerialRoleCreateAction::class)->handle($data),
        ['employee_id']
    );
});

it('fails to create a job title assignment for non title', function (): void {
    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->make([
        'managerial_role_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(ManagerialRoleCreateAction::class)->handle($data),
        ['managerial_role_id']
    );
});

it('fails to create managerial role when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(ManagerialRoleCreateAction::class)->handle(
            ManagerialRoleData::from(EmployeeManagerialRole::factory()->make($overrides))
        ),
        $fields
    );
})->with('managerial role dataset');
