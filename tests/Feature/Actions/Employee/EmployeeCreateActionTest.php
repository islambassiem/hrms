<?php

declare(strict_types=1);

use App\Actions\Employee\EmployeeCreateAction;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;
use App\Models\User;

it('creates an employee with authenticated user audit fields', function (): void {
    $employee = resolve(EmployeeCreateAction::class)->handle(
        EmployeeData::from(Employee::factory()->make())
    );

    expect($employee)->toBeInstanceOf(Employee::class);

    $this->assertDatabaseHas('employees', $employee->getAttributes());
});

it('fails to create a non-unique user id', function (): void {
    $user = User::factory()->create();
    Employee::factory()->create([
        'user_id' => $user->id,
    ]);

    expectValidationError(
        fn () => resolve(EmployeeCreateAction::class)->handle(
            EmployeeData::from(Employee::factory()->make([
                'user_id' => $user->id,
            ]))
        ), ['user_id']
    );
});

it('fails to create an employee with duplicate field', function (string $field, string $value): void {
    $employee = Employee::factory()->create([
        $field => $value,
    ]);

    expectValidationError(
        fn () => resolve(EmployeeCreateAction::class)->handle(
            EmployeeData::from(Employee::factory()->make([
                $field => $employee->$field,
            ]))
        ), [$field]
    );
})->with([
    ['field' => 'employee_code', 'value' => '500322'],
    ['field' => 'email', 'value' => '500322@inaya.edu.sa'],
]);

it('fails to create employee with non existing :dataset', function (string $column, int $value = PHP_INT_MIN): void {
    expectValidationError(
        fn () => resolve(EmployeeCreateAction::class)->handle(
            EmployeeData::from(Employee::factory()->make([
                $column => $value,
            ]))
        ), [$column]
    );
})->with([
    'user' => ['user_id'],
    'head' => ['head_id'],
    'gender' => ['gender_id'],
    'category' => ['category_id'],
    'department' => ['department_id'],
    'nationality' => ['nationality_id'],
    'place of birth country' => ['place_of_birth_id'],
    'marital status' => ['marital_status_id'],
    'religion' => ['religion_id'],
    'special need' => ['special_need_id'],
]);

it('fails to create employee when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeCreateAction::class)->handle(
            EmployeeData::from(Employee::factory()->make($overrides))
        ), $fields
    );
})->with('employee dataset');
