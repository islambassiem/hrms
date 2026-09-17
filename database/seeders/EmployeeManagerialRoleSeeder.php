<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeManagerialRole;
use App\Models\Lookup\ManagerialRole;
use Illuminate\Database\Seeder;

class EmployeeManagerialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $managerialRoleIds = ManagerialRole::query()->pluck('id');

        EmployeeManagerialRole::factory(10)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'managerial_role_id' => fn () => $managerialRoleIds->random(),
        ]);
    }
}
