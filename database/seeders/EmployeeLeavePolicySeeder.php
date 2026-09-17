<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\EmployeeLeavePolicy;
use App\Models\Leave\LeavePolicy;
use Illuminate\Database\Seeder;

class EmployeeLeavePolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $policyIds = LeavePolicy::query()->pluck('id');

        EmployeeLeavePolicy::factory(50)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'leave_policy_id' => fn () => $policyIds->random(),
        ]);
    }
}
