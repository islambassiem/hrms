<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\JobTitle;
use Illuminate\Database\Seeder;

class EmployeeJobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $jobTitleIds = JobTitle::query()->pluck('id');

        EmployeeJobTitle::factory(10)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'job_title_id' => fn () => $jobTitleIds->random(),
        ]);
    }
}
