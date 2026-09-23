<?php

use App\Actions\Payroll\EmployeeBankCreateAction;
use App\Actions\Payroll\EmployeeBankUpdateAction;
use App\Data\Payroll\EmployeeBankData;
use App\Models\Employee\Employee;
use App\Models\Payroll\EmployeeBank;

it('creates a payroll employee bank', function (): void {
    $data = EmployeeBankData::from(EmployeeBank::factory()->make());
    $employeeBank = resolve(EmployeeBankCreateAction::class)->handle($data);

    expect($employeeBank)->toBeInstanceOf(EmployeeBank::class);
    $this->assertDatabaseHas('payroll_employee_banks', $employeeBank->getAttributes());
});

test('action fails when employee already has a bank account', function (): void {
    $employee = Employee::factory()->create();
    EmployeeBank::factory()->create([
        'employee_id' => $employee->id,
    ]);

    $data = EmployeeBankData::from(
        EmployeeBank::factory()->make([
            'employee_id' => $employee->id,
        ])
    );

    expectValidationError(
        fn () => resolve(EmployeeBankCreateAction::class)->handle($data),
        ['employee_id'],
    );
});

test('action fails when iban already exists', function (): void {
    EmployeeBank::factory()->create([
        'iban' => 'SA0000000000000000000000',
    ]);

    $data = EmployeeBankData::from(
        EmployeeBank::factory()->make([
            'iban' => 'SA0000000000000000000000',
        ])
    );

    expectValidationError(
        fn () => resolve(EmployeeBankCreateAction::class)->handle($data),
        ['iban'],
    );
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(EmployeeBankCreateAction::class)->handle(
            EmployeeBankData::from(
                EmployeeBank::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Employee Bank Dataset');

it('updates a payroll employee bank', function (): void {
    $employeeBank = EmployeeBank::factory()->create();
    $data = EmployeeBankData::from(EmployeeBank::factory()->make());
    $updatedBank = resolve(EmployeeBankUpdateAction::class)
        ->handle($employeeBank, $data);

    expect($updatedBank->iban)->toBe($data->iban);
    $this->assertDatabaseHas('payroll_employee_banks', $updatedBank->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    $employeeBank = EmployeeBank::factory()->create();
    expectValidationError(
        fn () => resolve(EmployeeBankUpdateAction::class)->handle(
            $employeeBank,
            EmployeeBankData::from(
                EmployeeBank::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Employee Bank Dataset');

dataset('Employee Bank Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('bank_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('iban')
        ->required()
        ->notString()
        ->tooLong(34)
        ->build(),
]);
