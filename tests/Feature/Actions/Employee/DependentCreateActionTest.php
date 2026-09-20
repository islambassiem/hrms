<?php

declare(strict_types=1);

use App\Actions\Employee\DependentCreateAction;
use App\Data\Employee\DependentData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeDependent;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates an employee dependent with authenticated user audit fields', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $this->actingAs($user);

    $data = DependentData::from(EmployeeDependent::factory()->make([
        'employee_id' => $employee->id,
    ]));

    $action = new DependentCreateAction;
    $dependent = $action->handle($data);

    expect($dependent)->toBeInstanceOf(EmployeeDependent::class);

    $this->assertDatabaseHas('employee_dependents', [
        'employee_id' => $employee->id,
        'identification' => $dependent->identification,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when identification is already taken', function (): void {
    EmployeeDependent::factory()->create(['identification' => '1098765432']);
    $employee = Employee::factory()->create();

    $data = DependentData::from(EmployeeDependent::factory()->make([
        'employee_id' => $employee->id,
        'identification' => '1098765432',
    ]));

    $action = new DependentCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when date_of_birth is in the future', function (): void {
    $employee = Employee::factory()->create();

    $data = DependentData::from([
        'employee_id' => $employee->id,
        'identification' => '1122334455',
        'gender_id' => 1,
        'date_of_birth' => now()->addYear(),
        'relationship_id' => 1,
    ]);

    $action = new DependentCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);
