<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\EmployeeSickLeaveCycle;
use Illuminate\Database\Seeder;

class EmployeeSickLeaveCycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');

        EmployeeSickLeaveCycle::factory()->create([
            'employee_id' => fn () => $employeeIds->random(),
        ]);
    }
}
