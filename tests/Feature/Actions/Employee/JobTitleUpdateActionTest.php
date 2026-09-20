<?php

declare(strict_types=1);

use App\Actions\Employee\JobTitleUpdateAction;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;

it('updates a job title', function (): void {
    $employee = Employee::factory()->create();
    $jobTitle = EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $data = JobTitleData::from(EmployeeJobTitle::factory()->make());
    $updatedJobTitle = resolve(JobTitleUpdateAction::class)->handle($jobTitle, $data);

    expect($updatedJobTitle)->toBeInstanceOf(EmployeeJobTitle::class);
    $this->assertDatabaseHas('employee_job_titles', $updatedJobTitle->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(JobTitleUpdateAction::class)->handle(
            EmployeeJobTitle::factory()->create(),
            JobTitleData::from(EmployeeJobTitle::factory()->make($overrides)),
        ),
        $fields,
    );
})->with('job title dataset');
