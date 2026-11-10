<?php

declare(strict_types=1);

use App\Data\Head\DepartmentHeadEmployeeFiltersData;
use App\Models\Employee\Employee;
use App\Models\Lookup\Gender;
use App\Models\Lookup\ScientificDegree;
use App\Models\Qualifications\Qualification;
use App\Queries\Head\DepartmentHeadEmployeeDirectoryQuery;

test('directory query returns only active direct reports with the required relations', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $gender = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    $degree = ScientificDegree::factory()->create([
        'name_en' => 'Bachelor',
        'name_ar' => 'بكالوريوس',
    ]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'gender_id' => $gender->id,
        'employee_code' => '500101',
        'image' => 'employees/500101.png',
    ]);
    $subordinate->user()->update(['email' => 'sara.employee@college.test']);
    $qualification = Qualification::factory()->create([
        'employee_id' => $subordinate->id,
        'scientific_degree_id' => $degree->id,
        'graduation_date' => '2022-06-01',
        'is_last_qualification' => true,
    ]);
    Qualification::factory()->create([
        'employee_id' => $subordinate->id,
        'graduation_date' => '2018-06-01',
        'is_last_qualification' => false,
    ]);
    Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => false,
    ]);
    Employee::factory()->create(['is_active' => true]);

    $employees = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData)
        ->get();

    expect($employees->modelKeys())->toBe([$subordinate->id]);

    $result = $employees->first();

    expect($result)->not->toBeNull()
        ->and($result->relationLoaded('user'))->toBeTrue()
        ->and($result->relationLoaded('gender'))->toBeTrue()
        ->and($result->relationLoaded('latestQualification'))->toBeTrue()
        ->and($result->latestQualification?->is($qualification))->toBeTrue()
        ->and($result->user?->email)->toBe('sara.employee@college.test')
        ->and($result->gender?->name_en)->toBe('Female');
});

test('directory query searches every stored localized name part and official User email', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $englishNameEmployee = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'first_name_en' => 'Mary',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Jane',
    ]);
    $englishNameEmployee->user()->update(['email' => 'mary.jane@college.test']);

    $arabicNameEmployee = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'first_name_ar' => 'ليلى',
        'middle_name_ar' => null,
        'third_name_ar' => null,
        'last_name_ar' => 'حسن',
    ]);
    $emailEmployee = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $emailEmployee->user()->update(['email' => 'official.contact@college.test']);

    $query = resolve(DepartmentHeadEmployeeDirectoryQuery::class);

    expect($query->run($departmentHead, new DepartmentHeadEmployeeFiltersData(search: 'Mary Jane'))
        ->pluck('id')->all())->toBe([$englishNameEmployee->id])
        ->and($query->run($departmentHead, new DepartmentHeadEmployeeFiltersData(search: 'ليلى حسن'))
            ->pluck('id')->all())->toBe([$arabicNameEmployee->id])
        ->and($query->run($departmentHead, new DepartmentHeadEmployeeFiltersData(search: 'official.contact@college.test'))
            ->pluck('id')->all())->toBe([$emailEmployee->id]);
});

test('directory query filters by persisted gender and retains stable employee-code ordering', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $female = Gender::factory()->create();
    $male = Gender::factory()->create();
    $firstEmployee = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'gender_id' => $female->id,
        'employee_code' => '500100',
    ]);
    Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'gender_id' => $male->id,
        'employee_code' => '500099',
    ]);

    $employees = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData(genderId: $female->id))
        ->get();

    expect($employees->modelKeys())->toBe([$firstEmployee->id]);

    $allEmployees = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData)
        ->get();

    expect($allEmployees->modelKeys())->toHaveCount(2)
        ->and($allEmployees->first()?->employee_code)->toBe('500099');
});

test('directory query returns an empty collection when the Head has no active direct reports', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);

    $employees = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData)
        ->get();

    expect($employees)->toBeEmpty();
});

test('directory query results can be paginated in employee-code order', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);

    foreach (range(16, 1) as $employeeNumber) {
        Employee::factory()->create([
            'head_id' => $departmentHead->id,
            'is_active' => true,
            'employee_code' => sprintf('HDE-%04d', $employeeNumber),
        ]);
    }

    $query = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData);
    $firstPage = $query->paginate(15, ['*'], 'page', 1);
    $secondPage = resolve(DepartmentHeadEmployeeDirectoryQuery::class)
        ->run($departmentHead, new DepartmentHeadEmployeeFiltersData)
        ->paginate(15, ['*'], 'page', 2);

    expect($firstPage->count())->toBe(15)
        ->and($firstPage->total())->toBe(16)
        ->and($firstPage->first()?->employee_code)->toBe('HDE-0001')
        ->and($secondPage->count())->toBe(1)
        ->and($secondPage->first()?->employee_code)->toBe('HDE-0016');
});
