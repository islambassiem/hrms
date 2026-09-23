<?php

use App\Actions\Payroll\Salary\EmployeeSalaryComponentCreateAction;
use App\Actions\Payroll\Salary\EmployeeSalaryComponentUpdateAction;
use App\Data\Payroll\Salary\EmployeeSalaryComponentData;
use App\Models\Payroll\Salary\EmployeeSalaryComponent;

it('creates an employee salary component', function (): void {
    $component = resolve(EmployeeSalaryComponentCreateAction::class)->handle(
        EmployeeSalaryComponentData::from(
            EmployeeSalaryComponent::factory()->make()
        )
    );

    expect($component)->toBeInstanceOf(EmployeeSalaryComponent::class);
    $this->assertDatabaseHas('payroll_employee_salary_components', $component->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeSalaryComponentCreateAction::class)->handle(
            EmployeeSalaryComponentData::from(
                EmployeeSalaryComponent::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Employee Salary Component Dataset');

it('updates an employee salary component', function (): void {
    $updated = resolve(EmployeeSalaryComponentUpdateAction::class)->handle(
        EmployeeSalaryComponent::factory()->create(),
        EmployeeSalaryComponentData::from(
            EmployeeSalaryComponent::factory()->make()
        )
    );

    expect($updated)->toBeInstanceOf(EmployeeSalaryComponent::class);
    $this->assertDatabaseHas('payroll_employee_salary_components', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeSalaryComponentUpdateAction::class)->handle(
            EmployeeSalaryComponent::factory()->create(),
            EmployeeSalaryComponentData::from(
                EmployeeSalaryComponent::factory()->make($overrides),
            )
        ),
        $fields
    );
})->with('Employee Salary Component Dataset');

dataset('Employee Salary Component Dataset', [
    ...invalid('employee_id')
        ->required()
        // ->notInteger()
        ->build(),

    ...invalid('component_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('amount')
        ->required()
        ->belowMin(0)
        ->build(),

    ...invalid('effective_from')
        ->required()
        ->build(),

    ...invalid('effective_to')
        ->build(),

    ...invalid('revision_id')
        ->notInteger()
        ->build(),
]);
