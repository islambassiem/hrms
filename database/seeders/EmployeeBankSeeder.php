<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Lookup\Bank;
use App\Models\Payroll\EmployeeBank;
use Illuminate\Database\Seeder;

class EmployeeBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $bankIds = Bank::query()->pluck('id');

        EmployeeBank::factory(100)->create([
            'employee_id' => fn () => $employeeIds->pop(),
            'bank_id' => fn () => $bankIds->random(),
        ]);

    }
}
