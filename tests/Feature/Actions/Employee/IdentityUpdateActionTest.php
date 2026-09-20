<?php

declare(strict_types=1);

use App\Actions\Employee\IdentityUpdateAction;
use App\Data\Employee\IdentityData;
use App\Models\Employee\EmployeeIdentity;

it('updates an identity with authenticated user', function (): void {
    $identity = EmployeeIdentity::factory()->create();
    $data = IdentityData::from(EmployeeIdentity::factory()->make());
    $updatedIdentity = resolve(IdentityUpdateAction::class)->handle($identity, $data);

    expect($updatedIdentity)->toBeInstanceOf(EmployeeIdentity::class);
    $this->assertDatabaseHas('employee_identities', $updatedIdentity->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(IdentityUpdateAction::class)->handle(
            EmployeeIdentity::factory()->create(),
            IdentityData::from(EmployeeIdentity::factory()->make($overrides))
        ), $fields);
})->with('identity dataset');
