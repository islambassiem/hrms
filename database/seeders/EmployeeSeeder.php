<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Lookup\Category;
use App\Models\Lookup\Department;
use App\Models\Lookup\Gender;
use App\Models\Lookup\MaritalStatus;
use App\Models\Lookup\Religion;
use App\Models\Lookup\SpecialNeed;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(300)->create();
        $maritalStatisIds = MaritalStatus::query()->pluck('id');
        $religionIds = Religion::query()->pluck('id');
        $specialNeedIds = SpecialNeed::query()->pluck('id');
        $genderIds = Gender::query()->pluck('id');
        $countryIds = Category::query()->pluck('id');
        $departmentIds = Department::query()->pluck('id');

        foreach ($users as $user) {
            Employee::factory()->create([
                'user_id' => $user->id,
                'marital_status_id' => fn () => $maritalStatisIds->random(),
                'religion_id' => fn () => $religionIds->random(),
                'special_need_id' => fn () => $specialNeedIds->random(),
                'gender_id' => fn () => $genderIds->random(),
                'category_id' => fn () => $countryIds->random(),
                'department_id' => fn () => $departmentIds->random(),
                'nationality_id' => fn () => $countryIds->random(),
                'place_of_birth_id' => fn () => $countryIds->random(),
            ]);
        }

        $employees = Employee::all();

        foreach ($employees as $employee) {
            /** @var Employee $head */
            $head = $employees->random();
            $employee->update([
                'head_id' => $head->id,
            ]);
        }
    }
}
