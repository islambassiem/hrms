<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\YearTypeEnum;
use App\Models\Leave\LeavePeriod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<LeavePeriod>
 */
class LeavePeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Date::parse(fake()->date())->startOfYear();

        return [
            'name_en' => fake()->word(),
            'name_ar' => fake('ar_SA')->word(),
            'code' => fake()->unique()->numberBetween(1, 10000000000000),
            'type' => fake()->randomElement(YearTypeEnum::cases()),
            'start_date' => $startDate,
            'end_date' => $startDate->addYearNoOverflow(),
            'is_closed' => fake()->boolean(),
        ];
    }
}
