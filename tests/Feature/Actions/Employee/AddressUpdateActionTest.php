<?php

declare(strict_types=1);

use App\Actions\Employee\AddressUpdateAction;
use App\Data\Employee\AddressData;
use App\Models\Employee\EmployeeAddress;

it('updates an employee address', function (): void {
    $address = EmployeeAddress::factory()->create();
    $data = AddressData::from(EmployeeAddress::factory()->make());
    $updatedAddress = resolve(AddressUpdateAction::class)
        ->handle($address, $data);

    expect($updatedAddress->short_address)->toBe($data->short_address);
    $this->assertDatabaseHas('employee_addresses', $updatedAddress->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    $address = EmployeeAddress::factory()->create();
    expectValidationError(
        fn () => resolve(AddressUpdateAction::class)->handle(
            $address,
            AddressData::from(
                EmployeeAddress::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Address Dataset');
