<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Lookup\SalaryRevision;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayrollRun;
use Illuminate\Database\Seeder;

class PayrollPayslipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $run = PayrollRun::query()->get()->random();
        $employees = Employee::query()->get();
        $revisionIds = SalaryRevision::query()->pluck('id');

        foreach ($employees as $employee) {
            PayrollPayslip::factory()
                ->forRunAndEmployee($run, $employee)
                ->create([
                    'salary_revision_id' => fn () => $revisionIds->random(),
                ]);
        }
    }
}
