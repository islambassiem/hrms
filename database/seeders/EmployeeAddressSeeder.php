<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeAddress;
use Illuminate\Database\Seeder;

class EmployeeAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');

        EmployeeAddress::factory($employeeIds->count())->create([
            'employee_id' => fn () => $employeeIds->pop(),
        ]);
    }
}
