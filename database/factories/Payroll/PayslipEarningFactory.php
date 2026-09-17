<?php

declare(strict_types=1);

namespace Database\Factories\Payroll;

use App\Models\Lookup\Earning;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayslipEarning;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayslipEarning>
 */
class PayslipEarningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payslip_id' => PayrollPayslip::factory(),
            'earning_id' => Earning::factory(),
            'amount' => fake()->numberBetween(),
            'description' => fake()->sentence(),
        ];
    }
}
