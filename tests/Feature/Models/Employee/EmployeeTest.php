<?php

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\JobTitle;

it('fetches all current job titles', function (): void {
    $employee = Employee::factory()->create();

    $currentAssignments = EmployeeJobTitle::factory(3)->create([
        'employee_id' => $employee->id,
        'job_title_id' => fn () => JobTitle::factory()->create()->id,
        'end_date' => null,
    ]);

    $endedAssignment = EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => JobTitle::factory()->create()->id,
        'end_date' => now()->subDay(),
    ]);

    $currentJobTitles = $employee->currentJobTitles;

    expect($currentJobTitles->pluck('id')->contains($endedAssignment->id))
        ->toBeFalse();

    expect($currentJobTitles->pluck('id'))
        ->toEqualCanonicalizing($currentAssignments->pluck('id'));
});

it('fetches all job titles', function (): void {
    $employee = Employee::factory()->create();

    $currentAssignments = EmployeeJobTitle::factory(3)->create([
        'employee_id' => $employee->id,
        'job_title_id' => fn () => JobTitle::factory()->create()->id,
        'end_date' => null,
    ]);

    $endedAssignments = EmployeeJobTitle::factory(3)->create([
        'employee_id' => $employee->id,
        'job_title_id' => fn () => JobTitle::factory()->create()->id,
        'end_date' => now()->subDay(),
    ]);

    $jobTitles = $employee->jobTitles;

    expect($jobTitles->pluck('id'))
        ->toEqualCanonicalizing(
            $currentAssignments
                ->merge($endedAssignments)
                ->pluck('id')
        );

});

it('fetches the latest current job title', function (): void {
    $employee = Employee::factory()->create();

    EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => JobTitle::factory()->create()->id,
        'start_date' => now()->subMonths(3),
        'end_date' => null,
    ]);

    $latestCurrentAssignment = EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => JobTitle::factory()->create()->id,
        'start_date' => now()->subMonth(),
        'end_date' => null,
    ]);

    expect($employee->latestCurrentJobTitle()->is($latestCurrentAssignment))
        ->toBeTrue();
});

it('returns null when the employee has no current job titles', function (): void {
    $employee = Employee::factory()->create();

    EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
        'job_title_id' => JobTitle::factory()->create()->id,
        'start_date' => now()->subMonth(),
        'end_date' => now()->subDay(),
    ]);

    expect($employee->latestCurrentJobTitle)
        ->toBeNull();
});
