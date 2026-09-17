<?php

declare(strict_types=1);

namespace Database\Factories\Payroll;

use App\Models\Lookup\Deduction;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayslipDeduction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayslipDeduction>
 */
class PayslipDeductionFactory extends Factory
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
            'deduction_id' => Deduction::factory(),
            'amount' => fake()->numberBetween(),
            'description' => fake()->sentence(),
        ];
    }
}
