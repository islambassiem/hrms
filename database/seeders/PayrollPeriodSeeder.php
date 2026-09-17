<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Payroll\PayrollPeriod;
use Illuminate\Database\Seeder;

class PayrollPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PayrollPeriod::factory(10)->create();
    }
}
