<?php

use App\Actions\Employee\ContractCreateAction;
use App\Data\Employee\ContractData;
use App\Models\Employee\EmployeeContract;

it('creates an employee contract', function (): void {
    $data = ContractData::from(EmployeeContract::factory()->make());
    $contract = resolve(ContractCreateAction::class)->handle($data);

    expect($contract)->toBeInstanceOf(EmployeeContract::class);
    $this->assertDatabaseHas('employee_contracts', $contract->getAttributes());
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(ContractCreateAction::class)->handle(
            ContractData::from(
                EmployeeContract::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Contract Dataset');

dataset('Contract Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('duration')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('probation_period')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('notice_period')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('type')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->required()
        ->invalidDateOrder('start_date', 'end_date')
        ->build(),
]);
