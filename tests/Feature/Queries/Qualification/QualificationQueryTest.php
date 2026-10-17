<?php

use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use App\Queries\Qualification\EmployeeQualificationsQuery;

it('fetches the employee qualifications if employee given', function (): void {
    $employee = Employee::factory()->create();

    Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);

    Qualification::factory()->create([
        'employee_id' => Employee::factory()->create()->id,
    ]);

    $results = resolve(EmployeeQualificationsQuery::class)
        ->run($employee)
        ->get();

    expect($results)->toHaveCount(1)
        ->and($results->first()->employee_id)
        ->toBe($employee->id);
});

it('fetches all qualifications if no employee given', function (): void {
    Qualification::factory(6)->create();

    $results = resolve(EmployeeQualificationsQuery::class)
        ->run()
        ->get();

    expect($results)->toHaveCount(6);
});
