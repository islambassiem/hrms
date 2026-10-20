<?php

use App\Actions\AttachMediaAction;
use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use App\Queries\Qualification\EmployeeQualificationsQuery;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

it('eager loads qualification media required by the resource', function (): void {
    Storage::fake(config('media-library.disk_name'));

    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    resolve(AttachMediaAction::class)->handle(
        $qualification,
        UploadedFile::fake()->create(
            'degree-certificate.pdf',
            128,
            'application/pdf',
        ),
    );

    $result = resolve(EmployeeQualificationsQuery::class)
        ->run($employee)
        ->sole();

    expect($result->relationLoaded('media'))->toBeTrue()
        ->and($result->getMedia())->toHaveCount(1);
});
