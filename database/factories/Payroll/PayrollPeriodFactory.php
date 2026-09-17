<?php

declare(strict_types=1);

namespace Database\Factories\Payroll;

use App\Models\Payroll\PayrollPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayrollPeriod>
 */
class PayrollPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->date('F Y'),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'pay_date' => fake()->date(),
            'status' => fake()->word(),
        ];
    }
}
