<?php

declare(strict_types=1);

use App\Actions\Employee\AddressCreateAction;
use App\Data\Employee\AddressData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeAddress;

it('creates an employee address', function (): void {
    $data = AddressData::from(EmployeeAddress::factory()->make());
    $address = resolve(AddressCreateAction::class)->handle($data);

    expect($address)->toBeInstanceOf(EmployeeAddress::class);
    $this->assertDatabaseHas('employee_addresses', $address->getAttributes());
});

test('action fails when employee already exists', function (): void {
    $employee = Employee::factory()->create();
    EmployeeAddress::factory()->create([
        'employee_id' => $employee->id,
    ]);

    $data = AddressData::from(
        EmployeeAddress::factory()->make([
            'employee_id' => $employee->id,
        ])
    );

    expectValidationError(
        fn () => resolve(AddressCreateAction::class)->handle($data),
        ['employee_id'],
    );
});

test('action fails when short address already exists', function (): void {
    EmployeeAddress::factory()->create([
        'short_address' => 'Existing Address',
    ]);

    $data = AddressData::from(
        EmployeeAddress::factory()->make([
            'short_address' => 'Existing Address',
        ])
    );

    expectValidationError(
        fn () => resolve(AddressCreateAction::class)->handle($data),
        ['short_address'],
    );
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(AddressCreateAction::class)->handle(
            AddressData::from(
                EmployeeAddress::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Address Dataset');
