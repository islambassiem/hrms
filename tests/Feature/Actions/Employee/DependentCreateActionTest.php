<?php

declare(strict_types=1);

use App\Actions\Employee\DependentCreateAction;
use App\Data\Employee\DependentData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeDependent;

it('creates an employee dependent', function (): void {
    $employee = Employee::factory()->create();
    $dependent = resolve(DependentCreateAction::class)->handle(
        DependentData::from(EmployeeDependent::factory()->make([
            'employee_id' => $employee->id,
        ]))
    );

    expect($dependent)->toBeInstanceOf(EmployeeDependent::class);
    $this->assertDatabaseHas('employee_dependents', [
        'employee_id' => $employee->id,
        'identification' => $dependent->identification,
    ]);
});

it('fails to create a dependent for non employee', function (): void {
    expectValidationError(
        fn () => resolve(DependentCreateAction::class)->handle(
            DependentData::from(EmployeeDependent::factory()->make([
                'employee_id' => 99999,
            ]))
        ),
        ['employee_id']
    );
});

it('fails to create a dependent for wrong relationship', function (): void {
    expectValidationError(
        fn () => resolve(DependentCreateAction::class)->handle(
            DependentData::from(EmployeeDependent::factory()->make([
                'relationship_id' => 99999,
            ]))
        ),
        ['relationship_id']
    );
});

it('fails to create a dependent for wrong gender', function (): void {
    expectValidationError(
        fn () => resolve(DependentCreateAction::class)->handle(
            DependentData::from(EmployeeDependent::factory()->make([
                'gender_id' => 99999,
            ]))
        ),
        ['gender_id']
    );
});

it('fails to create a dependent when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(DependentCreateAction::class)->handle(
            DependentData::from(EmployeeDependent::factory()->make($overrides))
        ),
        $fields
    );
})->with('dependent dataset');
