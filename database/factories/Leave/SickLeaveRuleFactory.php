<?php

namespace Database\Factories\Leave;

use App\Models\Leave\SickLeaveRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<SickLeaveRule>
 */
class SickLeaveRuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Date::parse(fake()->date());

        return [
            'no_of_days' => fake()->numberBetween(30, 60),
            'pay_rate' => fake()->randomFloat(2, 0.00, 100.00),
            'effective_from' => $startDate,
            'effective_to' => fake()->randomElement([null, $startDate->addYearNoOverflow()]),
        ];
    }
}
