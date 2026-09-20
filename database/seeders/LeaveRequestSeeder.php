<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeIds = LeaveType::query()->pluck('id');
        $employeeIds = Employee::query()->pluck('id');

        LeaveRequest::factory(100)->create([
            'leave_type_id' => fn () => $typeIds->random(),
            'employee_id' => fn () => $employeeIds->random(),
        ]);
    }
}
