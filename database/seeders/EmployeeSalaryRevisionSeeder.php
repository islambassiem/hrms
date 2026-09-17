<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Lookup\SalaryRevision;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Database\Seeder;

class EmployeeSalaryRevisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = SalaryRevision::query()->pluck('id');

        EmployeeSalaryRevision::factory(100)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'revision_type_id' => fn () => $typeIds->random(),
        ]);
    }
}
