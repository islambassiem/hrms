<?php

declare(strict_types=1);

use App\Actions\Employee\IdentityCreateAction;
use App\Data\Employee\IdentityData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeIdentity;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates an identity with authenticated user audit fields', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $this->actingAs($user);

    $data = IdentityData::from(EmployeeIdentity::factory()->make([
        'employee_id' => $employee->id,
    ]));

    $action = new IdentityCreateAction;
    $identity = $action->handle($data);

    expect($identity)->toBeInstanceOf(EmployeeIdentity::class);

    $this->assertDatabaseHas('employee_identities', [
        'id' => $identity->id,
        'employee_id' => $employee->id,
        'identity_number' => $data->identity_number,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when identity_number is not unique', function (): void {
    EmployeeIdentity::factory()->create(['identity_number' => '1010101010']);
    $employee = Employee::factory()->create();

    $data = IdentityData::from([
        'employee_id' => $employee->id,
        'identity_type_id' => 1,
        'identity_number' => '1010101010',
    ]);

    $action = new IdentityCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when expiry_date is before issue_date', function (): void {
    $employee = Employee::factory()->create();

    $data = IdentityData::from([
        'employee_id' => $employee->id,
        'identity_type_id' => 1,
        'identity_number' => '1010101011',
        'issue_date' => now()->subYear(),
        'expiry_date' => now()->subYears(2),
    ]);

    $action = new IdentityCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);
