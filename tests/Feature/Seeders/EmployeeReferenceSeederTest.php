<?php

declare(strict_types=1);

use App\Models\Employee\Employee;
use App\Models\Lookup\Gender;
use App\Models\Lookup\LeaveType;
use App\Models\Lookup\SalaryRevision;
use App\Models\User;
use Database\Seeders\EmployeeContractSeeder;
use Database\Seeders\FamilyVisitSeeder;
use Database\Seeders\LeaveRequestSeeder;
use Database\Seeders\LetterSeeder;
use Database\Seeders\VisaSeeder;

test('employee-reference seeders reuse existing employees and gender lookup records', function (): void {
    $male = Gender::factory()->create([
        'code' => '1',
        'name_en' => 'Male',
        'name_ar' => 'ذكر',
    ]);
    $female = Gender::factory()->create([
        'code' => '2',
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    $genderIds = collect([$male->id, $female->id]);

    Employee::factory(50)->create([
        'gender_id' => fn () => $genderIds->random(),
    ]);
    LeaveType::factory()->create();
    SalaryRevision::factory()->create();

    $employeeCount = Employee::query()->count();
    $genderCount = Gender::query()->count();
    $userCount = User::query()->count();

    $this->seed([
        EmployeeContractSeeder::class,
        LeaveRequestSeeder::class,
        LetterSeeder::class,
        FamilyVisitSeeder::class,
        VisaSeeder::class,
    ]);

    expect(Employee::query()->count())->toBe($employeeCount)
        ->and(Gender::query()->count())->toBe($genderCount)
        ->and(User::query()->count())->toBe($userCount)
        ->and(Employee::query()->whereNotIn('gender_id', $genderIds)->count())->toBe(0);
});
