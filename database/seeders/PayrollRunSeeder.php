<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Payroll\PayrollPeriod;
use App\Models\Payroll\PayrollRun;
use Illuminate\Database\Seeder;

class PayrollRunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodIds = PayrollPeriod::query()->pluck('id');
        $employeeIds = Employee::query()->pluck('id');

        PayrollRun::factory(30)->create([
            'period_id' => fn () => $periodIds->random(),
            'processed_by' => fn () => $employeeIds->random(),
            'approved_by' => fn () => $employeeIds->random(),
        ]);
    }
}
