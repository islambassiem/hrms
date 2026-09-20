<?php

declare(strict_types=1);

use App\Actions\Employee\JobTitleCreateAction;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('creates a job title assignment with authenticated user audit fields', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();

    $this->actingAs($user);

    $data = JobTitleData::from(EmployeeJobTitle::factory()->make([
        'employee_id' => $employee->id,
    ]));

    $action = new JobTitleCreateAction;
    $jobTitle = $action->handle($data);

    expect($jobTitle)->toBeInstanceOf(EmployeeJobTitle::class);

    $this->assertDatabaseHas('employee_job_titles', [
        'id' => $jobTitle->id,
        'employee_id' => $employee->id,
        'job_title_id' => $data->job_title_id,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when non-existent employee_id is provided', function (): void {
    $data = JobTitleData::from([
        'employee_id' => 99999,
        'job_title_id' => 1,
        'start_date' => now(),
    ]);

    $action = new JobTitleCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);

it('fails validation when end_date is before start_date', function (): void {
    $employee = Employee::factory()->create();

    $data = JobTitleData::from([
        'employee_id' => $employee->id,
        'job_title_id' => 1,
        'start_date' => now(),
        'end_date' => now()->subDay(),
    ]);

    $action = new JobTitleCreateAction;
    $action->handle($data);
})->throws(ValidationException::class);
