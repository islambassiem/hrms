<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\Earning;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayslipEarning;
use Illuminate\Database\Seeder;

class PayslipEarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payslipIds = PayrollPayslip::query()->pluck('id');
        $earningIds = Earning::query()->pluck('id');

        PayslipEarning::factory(300)->create([
            'payslip_id' => fn () => $payslipIds->random(),
            'earning_id' => fn () => $earningIds->random(),
        ]);
    }
}
