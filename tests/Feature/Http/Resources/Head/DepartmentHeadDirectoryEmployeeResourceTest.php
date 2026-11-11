<?php

declare(strict_types=1);

use App\Http\Resources\Head\DepartmentHeadDirectoryEmployeeResource;
use App\Models\Employee\Employee;
use App\Models\Lookup\Gender;
use App\Models\Lookup\ScientificDegree;
use App\Models\Qualifications\Qualification;

test('directory employee resource exposes the confirmed employee summary contract', function (): void {
    $gender = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    $degree = ScientificDegree::factory()->create([
        'name_en' => 'Master',
        'name_ar' => 'ماجستير',
    ]);
    $employee = Employee::factory()->create([
        'gender_id' => $gender->id,
        'employee_code' => '500201',
        'first_name_en' => 'Rana',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Ali',
        'image' => 'employees/500201.png',
    ]);
    $employee->user()->update(['email' => 'rana.ali@college.test']);
    Qualification::factory()->create([
        'employee_id' => $employee->id,
        'scientific_degree_id' => $degree->id,
        'graduation_date' => '2024-06-01',
        'is_last_qualification' => true,
    ]);
    $employee->load([
        'gender',
        'user',
        'latestQualification.major',
        'latestQualification.educationalSublevel',
        'latestQualification.scientificDegree',
    ]);

    $resource = DepartmentHeadDirectoryEmployeeResource::make($employee)->resolve();

    expect($resource)
        ->toMatchArray([
            'id' => $employee->id,
            'employeeCode' => '500201',
            'name' => 'Rana Ali',
            'image' => 'employees/500201.png',
            'gender' => [
                'id' => $gender->id,
                'name' => 'Female',
            ],
            'officialEmail' => 'rana.ali@college.test',
            'latestQualification' => [
                'scientificDegree' => 'Master',
                'educationalSublevel' => $employee->latestQualification->educationalSublevel?->name,
                'major' => $employee->latestQualification->major?->name,
                'graduationDate' => '2024-06-01',
            ],
        ]);
});

test('directory employee resource reports missing optional related data as null', function (): void {
    $employee = Employee::factory()->create();
    $employee->load(['gender', 'user', 'latestQualification']);

    $resource = DepartmentHeadDirectoryEmployeeResource::make($employee)->resolve();

    expect($resource['latestQualification'])->toBeNull()
        ->and($resource['officialEmail'])->toBe($employee->user?->email);
});
