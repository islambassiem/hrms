<?php

declare(strict_types=1);

use App\Actions\Employee\EmployeeUpdateAction;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates an employee with authenticated user', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $this->actingAs($user);

    $data = EmployeeData::from([
        ...$employee->toArray(),
        'first_name_en' => 'NewName',
        'joining_date' => now()->addDays(5),
        'date_of_birth' => now()->subYears(30),
    ]);

    $action = new EmployeeUpdateAction;
    $updatedEmployee = $action->handle($employee, $data);

    expect($updatedEmployee->first_name_en)->toBe($data->first_name_en);

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'first_name_en' => $data->first_name_en,
        'updated_by' => $user->id,
    ]);
});

it('allows keeping the same employee_code when updating', function (): void {
    $employee = Employee::factory()->create([
        'employee_code' => 'EMP-500',
        'joining_date' => now()->addDays(5),
    ]);

    $data = EmployeeData::from([
        ...$employee->toArray(),
        'employee_code' => 'EMP-500',
        'joining_date' => now()->addDays(5),
    ]);

    $action = new EmployeeUpdateAction;
    $updatedEmployee = $action->handle($employee, $data);

    expect($updatedEmployee->employee_code)->toBe('EMP-500');
});

it('fails validation when updating with an employee_code taken by another employee', function (): void {
    $employee1 = Employee::factory()->create(['employee_code' => 'EMP-001']);
    $employee2 = Employee::factory()->create([
        'employee_code' => 'EMP-002',
    ]);

    $data = EmployeeData::from([
        ...$employee2->toArray(),
        'employee_code' => $employee1->employee_code,
    ]);

    $action = new EmployeeUpdateAction;
    $action->handle($employee2, $data);
})->throws(ValidationException::class);

it('fails validation when leaving_date is before joining_date', function (): void {
    $employee = Employee::factory()->create();
    $data = EmployeeData::from(Employee::factory()->make([
        'joining_date' => now()->addDays(10),
        'leaving_date' => now()->addDays(2),
    ]));

    $action = new EmployeeUpdateAction;
    $action->handle($employee, $data);
})->throws(ValidationException::class);
