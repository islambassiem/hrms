<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\Deduction;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayslipDeduction;
use Illuminate\Database\Seeder;

class PayslipDeductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payslipIds = PayrollPayslip::query()->pluck('id');
        $deductionIds = Deduction::query()->pluck('id');

        PayslipDeduction::factory(300)->create([
            'payslip_id' => fn () => $payslipIds->random(),
            'deduction_id' => fn () => $deductionIds->random(),
        ]);
    }
}
