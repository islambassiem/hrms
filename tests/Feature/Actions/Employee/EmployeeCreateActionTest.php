<?php

declare(strict_types=1);

use App\Actions\Employee\EmployeeCreateAction;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates an employee with authenticated user audit fields', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $data = EmployeeData::from(Employee::factory()->make());

    $action = new EmployeeCreateAction;
    $employee = $action->handle($data);

    expect($employee)->toBeInstanceOf(Employee::class);

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'employee_code' => $data->employee_code,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('creates an employee without authenticated user', function (): void {
    $data = EmployeeData::from(Employee::factory()->make());

    $action = new EmployeeCreateAction;
    $employee = $action->handle($data);

    expect($employee)->toBeInstanceOf(Employee::class);
    expect($employee->created_by)->toBeNull()
        ->and($employee->updated_by)->toBeNull();

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'employee_code' => $data->employee_code,
        'created_by' => null,
        'updated_by' => null,
    ]);
});

it('fails validation when required fields are missing or invalid', function (): void {
    $data = EmployeeData::from(Employee::factory()->make([
        'user_id' => null,
        'employee_code' => '',
        'gender_id' => 99999,
        'category_id' => 1,
        'department_id' => 1,
        'nationality_id' => 1,
        'joining_date' => now()->addDays(1),
    ]));

    $action = new EmployeeCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when employee_code is not unique', function (): void {
    Employee::factory()->create(['employee_code' => '500322']);

    $data = EmployeeData::from(Employee::factory()->make([
        'employee_code' => '500322',
    ]));

    $action = new EmployeeCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);
