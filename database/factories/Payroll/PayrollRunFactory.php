<?php

declare(strict_types=1);

namespace Database\Factories\Payroll;

use App\Models\Employees\Employee;
use App\Models\Payroll\PayrollPeriod;
use App\Models\Payroll\PayrollRun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayrollRun>
 */
class PayrollRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'period_id' => PayrollPeriod::factory(),
            'run_type' => fake()->word(),
            'run_date' => fake()->date(),
            'status' => fake()->word(),
            'processed_by' => Employee::factory(),
            'approved_by' => Employee::factory(),
            'approved_at' => fake()->date(),
            'total_gross' => fake()->numberBetween(),
            'total_deductions' => fake()->numberBetween(),
            'total_net' => fake()->numberBetween(),
        ];
    }
}
