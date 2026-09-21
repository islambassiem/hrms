<?php

declare(strict_types=1);

use App\Actions\Employee\ManagerialRoleUpdateAction;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeManagerialRole;

it('updates a managerial role', function (): void {
    $employee = Employee::factory()->create();
    $role = EmployeeManagerialRole::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $data = ManagerialRoleData::from(EmployeeManagerialRole::factory()->make());
    $updatedJobTitle = resolve(ManagerialRoleUpdateAction::class)->handle($role, $data);

    expect($updatedJobTitle)->toBeInstanceOf(EmployeeManagerialRole::class);
    $this->assertDatabaseHas('employee_managerial_roles', $updatedJobTitle->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(ManagerialRoleUpdateAction::class)->handle(
            EmployeeManagerialRole::factory()->create(),
            ManagerialRoleData::from(EmployeeManagerialRole::factory()->make($overrides)),
        ),
        $fields,
    );
})->with('managerial role dataset');
