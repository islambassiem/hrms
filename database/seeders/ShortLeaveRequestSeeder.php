<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Database\Seeder;

class ShortLeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = ShortLeaveType::query()->pluck('id');

        ShortLeaveRequest::factory(50)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'short_leave_type_id' => fn () => $typeIds->random(),
        ]);
    }
}
