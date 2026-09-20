<?php

declare(strict_types=1);

use App\Actions\Employee\JobTitleUpdateAction;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\User;
use Illuminate\Validation\ValidationException;

it('updates a job title assignment with authenticated user', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create();
    $jobTitle = EmployeeJobTitle::factory()->create([
        'employee_id' => $employee->id,
    ]);

    $this->actingAs($user);

    $data = JobTitleData::from([
        ...$jobTitle->toArray(),
        'job_title_id' => $jobTitle->id,
    ]);

    $action = new JobTitleUpdateAction;
    $updatedJobTitle = $action->handle($jobTitle, $data);

    expect($updatedJobTitle->job_title_id)->toBe($jobTitle->id);

    $this->assertDatabaseHas('employee_job_titles', [
        'id' => $jobTitle->id,
        'job_title_id' => $jobTitle->id,
        'updated_by' => $user->id,
    ]);
});

it('fails validation when updating with an invalid end_date', function (): void {
    $jobTitle = EmployeeJobTitle::factory()->create([
        'start_date' => now(),
    ]);

    $data = JobTitleData::from([
        ...$jobTitle->toArray(),
        'end_date' => now()->subMonth(),
    ]);

    $action = new JobTitleUpdateAction;
    $action->handle($jobTitle, $data);
})->throws(ValidationException::class);
