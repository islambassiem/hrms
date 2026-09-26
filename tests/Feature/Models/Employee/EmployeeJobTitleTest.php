<?php

use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\JobTitle;
use Illuminate\Database\QueryException;

it('belongs to the assigned job title', function (): void {
    $jobTitle = JobTitle::factory()->create();

    $employeeJobTitle = EmployeeJobTitle::factory()->create([
        'job_title_id' => $jobTitle->id,
    ]);

    expect($employeeJobTitle->jobTitle->is($jobTitle))
        ->toBeTrue();
});

it('returns null when the job title does not exist', function (): void {
    EmployeeJobTitle::factory()->create([
        'job_title_id' => PHP_INT_MAX,
    ]);
})->throws(QueryException::class);
