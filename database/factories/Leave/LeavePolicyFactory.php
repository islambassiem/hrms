<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\AccrualFrequencyEnum;
use App\Enums\YearTypeEnum;
use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeavePolicy>
 */
class LeavePolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'leave_type_id' => LeaveType::factory(),
            'name_en' => fake()->word(),
            'name_ar' => fake('ar_SA')->word(),
            'days_per_year' => fake()->randomElement([0, 21, 30]),
            'accrual_frequency' => fake()->randomElement(AccrualFrequencyEnum::cases()),
            'period_type' => fake()->randomElement(YearTypeEnum::cases()),
            'allow_accumulation' => fake()->boolean(),
            'accumulation_periods' => fake()->randomElement([1, 2]),
            'allow_management_carryover' => fake()->boolean(),
            'expire_unused' => fake()->boolean(),
            'encash_on_termination' => fake()->boolean(),
            'pay_rate' => fake()->randomElement([0, 25, 50, 100]),
            'is_default' => fake()->boolean(),
        ];
    }
}
