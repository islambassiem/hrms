<?php

declare(strict_types=1);

use App\Actions\Employee\AddressCreateAction;
use App\Data\Employee\AddressData;
use App\Models\Employee\EmployeeAddress;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates an employee address', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $data = AddressData::from(EmployeeAddress::factory()->make());
    $address = resolve(AddressCreateAction::class)->handle($data);

    expect($address)->toBeInstanceOf(EmployeeAddress::class);

    $this->assertDatabaseHas('employee_addresses', [
        'id' => $address->id,
        'employee_id' => $data->employee_id,
        'short_address' => $data->short_address,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('fails when :dataset', function ($ovrrides) {
    expect(
        fn () => AddressData::from(EmployeeAddress::factory()->make($ovrrides))
    )->toThrow(ValidationException::class);
})
    ->with([
        'both are null' =>  [['employee_id' => null, 'short_address' => null]],
        'short_address is null' => [['employee_id' => 123, 'short_address' => null]],
        'employee_id is null' => [['employee_id' => null, 'short_address' => '123 Main St']],
    ]);

it('fails validation when non-existent employee_id is provided', function (): void {
    $data = AddressData::from([
        'employee_id' => 99999,
        'short_address' => 'RIYD1234',
    ]);

    $action = new AddressCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when employee_id already has an address', function (): void {
    $existingAddress = EmployeeAddress::factory()->create();

    $data = AddressData::from([
        'employee_id' => $existingAddress->employee_id,
        'short_address' => 'NEW1234',
    ]);

    $action = new AddressCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);


