<?php

use App\Actions\Payroll\Salary\EmployeeSalaryRevisionCreateAction;
use App\Actions\Payroll\Salary\EmployeeSalaryRevisionUpdateAction;
use App\Data\Payroll\Salary\EmployeeSalaryRevisionData;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;

it('creates an employee salary revision', function (): void {
    $revision = resolve(EmployeeSalaryRevisionCreateAction::class)->handle(
        EmployeeSalaryRevisionData::from(
            EmployeeSalaryRevision::factory()->make()
        )
    );

    expect($revision)->toBeInstanceOf(EmployeeSalaryRevision::class);
    $this->assertDatabaseHas('payroll_employee_salary_revisions', $revision->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeSalaryRevisionCreateAction::class)->handle(
            EmployeeSalaryRevisionData::from(
                EmployeeSalaryRevision::factory()->make($overrides)
            )
        ),
        $fields
    );
})->with('Employee Salary Revision Dataset');

it('updates an employee salary revision', function (): void {

    $updated = resolve(EmployeeSalaryRevisionUpdateAction::class)->handle(
        EmployeeSalaryRevision::factory()->create(),
        EmployeeSalaryRevisionData::from(
            EmployeeSalaryRevision::factory()->make()
        )
    );

    expect($updated)->toBeInstanceOf(EmployeeSalaryRevision::class);
    $this->assertDatabaseHas('payroll_employee_salary_revisions', $updated->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeSalaryRevisionUpdateAction::class)->handle(
            EmployeeSalaryRevision::factory()->create(),
            EmployeeSalaryRevisionData::from(EmployeeSalaryRevision::factory()->make($overrides))
        ),
        $fields
    );
})->with('Employee Salary Revision Dataset');

dataset('Employee Salary Revision Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('revision_type_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('effective_date')
        ->required()
        ->build(),

    ...invalid('previous_gross')
        ->belowMin(0)
        ->build(),

    ...invalid('new_gross')
        ->required()
        ->belowMin(0)
        ->build(),

    ...invalid('reason')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),
]);
