<?php

declare(strict_types=1);

use App\Actions\Employee\EmployeeUpdateAction;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;

it('updates an employee', function (): void {
    $updatedEmployee = resolve(EmployeeUpdateAction::class)->handle(
        Employee::factory()->create(),
        EmployeeData::from(Employee::factory()->make())
    );

    expect($updatedEmployee)->toBeInstanceOf(Employee::class);

    $this->assertDatabaseHas('employees', $updatedEmployee->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeUpdateAction::class)->handle(
            Employee::factory()->create(),
            EmployeeData::from(Employee::factory()->make($overrides))
        ), $fields
    );
})->with('employee dataset');
