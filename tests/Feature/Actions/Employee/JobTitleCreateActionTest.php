<?php

declare(strict_types=1);

use App\Actions\Employee\JobTitleCreateAction;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;

it('creates a job title assignment with authenticated user audit fields', function (): void {
    $employee = Employee::factory()->create();
    $data = JobTitleData::from(EmployeeJobTitle::factory()->make([
        'employee_id' => $employee->id,
    ]));
    $jobTitle = resolve(JobTitleCreateAction::class)->handle($data);

    expect($jobTitle)->toBeInstanceOf(EmployeeJobTitle::class);
    $this->assertDatabaseHas('employee_job_titles', $jobTitle->getAttributes());
});

it('fails to create a job title assignment for non employee', function (): void {
    $data = JobTitleData::from(EmployeeJobTitle::factory()->make([
        'employee_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(JobTitleCreateAction::class)->handle($data),
        ['employee_id']
    );
});

it('fails to create a job title assignment for non title', function (): void {
    $data = JobTitleData::from(EmployeeJobTitle::factory()->make([
        'job_title_id' => 999,
    ]));
    expectValidationError(
        fn () => resolve(JobTitleCreateAction::class)->handle($data),
        ['job_title_id']
    );
});

it('fails to create an identity when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(JobTitleCreateAction::class)->handle(
            JobTitleData::from(EmployeeJobTitle::factory()->make($overrides))
        ),
        $fields
    );
})->with('job title dataset');
