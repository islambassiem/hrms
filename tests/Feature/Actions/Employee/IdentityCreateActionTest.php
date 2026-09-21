<?php

declare(strict_types=1);

use App\Actions\Employee\IdentityCreateAction;
use App\Data\Employee\IdentityData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeIdentity;

it('creates an identity with authenticated user audit fields', function (): void {
    $employee = Employee::factory()->create();
    $data = IdentityData::from(EmployeeIdentity::factory()->make([
        'employee_id' => $employee->id,
    ]));
    $identity = resolve(IdentityCreateAction::class)->handle($data);

    expect($identity)->toBeInstanceOf(EmployeeIdentity::class);
    $this->assertDatabaseHas('employee_identities', $identity->getAttributes());
});

it('fails to create an identity for non employee', function (): void {
    $data = IdentityData::from(EmployeeIdentity::factory()->make([
        'employee_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(IdentityCreateAction::class)->handle($data),
        ['employee_id']
    );
});

it('fails to create an identity for non identity type', function (): void {
    $data = IdentityData::from(EmployeeIdentity::factory()->make([
        'identity_type_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(IdentityCreateAction::class)->handle($data),
        ['identity_type_id']
    );
});

it('fails to create an identity when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(IdentityCreateAction::class)->handle(
            IdentityData::from(EmployeeIdentity::factory()->make($overrides))
        ),
        $fields
    );
})->with('identity dataset');
