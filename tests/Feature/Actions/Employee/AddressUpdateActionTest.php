<?php

declare(strict_types=1);

use App\Actions\Employee\AddressUpdateAction;
use App\Data\Employee\AddressData;
use App\Models\Employee\EmployeeAddress;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates an employee address with authenticated user', function (): void {
    $user = User::factory()->create();
    $address = EmployeeAddress::factory()->create(['city' => 'Riyadh']);

    $this->actingAs($user);

    $data = AddressData::from(EmployeeAddress::factory()->make([
        'city' => 'Jeddah',
    ]));

    $action = new AddressUpdateAction;
    $updatedAddress = $action->handle($address, $data);

    expect($updatedAddress->city)->toBe('Jeddah');

    $this->assertDatabaseHas('employee_addresses', [
        'id' => $address->id,
        'city' => 'Jeddah',
        'updated_by' => $user->id,
    ]);
});

it('allows keeping the same employee_id when updating', function (): void {
    $address = EmployeeAddress::factory()->create(['city' => 'Riyadh']);

    $data = AddressData::from([
        ...$address->toArray(),
        'city' => 'Dammam',
    ]);

    $action = new AddressUpdateAction;
    $updatedAddress = $action->handle($address, $data);

    expect($updatedAddress->city)->toBe('Dammam');
});

it('fails validation when updating with another employee_id that already has an address', function (): void {
    $address1 = EmployeeAddress::factory()->create();
    $address2 = EmployeeAddress::factory()->create();

    $data = AddressData::from([
        ...$address2->toArray(),
        'employee_id' => $address1->employee_id,
    ]);

    $action = new AddressUpdateAction;
    $action->handle($address2, $data);
})->throws(ValidationException::class);
