<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeAddress;
use App\Models\Employee\EmployeeContract;
use App\Models\Lookup\SalaryRevision;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Database\Seeder;

class EmployeeContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::query()
            ->inRandomOrder()
            ->limit(50)
            ->get();
        $salaryRevisionIds = SalaryRevision::query()->pluck('id');

        $employees->each(function (Employee $employee) use ($salaryRevisionIds): void {
            $address = EmployeeAddress::factory()->create([
                'employee_id' => $employee->id,
            ]);
            $salaryRevision = EmployeeSalaryRevision::factory()->create([
                'employee_id' => $employee->id,
                'revision_type_id' => $salaryRevisionIds->random(),
            ]);

            EmployeeContract::factory()->create([
                'employee_id' => $employee->id,
                'salary_revision_id' => $salaryRevision->id,
                'address_id' => $address->id,
            ]);
        });
    }
}
