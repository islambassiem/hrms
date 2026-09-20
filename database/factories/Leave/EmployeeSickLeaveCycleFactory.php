<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Models\Employee\Employee;
use App\Models\Leave\EmployeeSickLeaveCycle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<EmployeeSickLeaveCycle>
 */
class EmployeeSickLeaveCycleFactory extends Factory
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
            'employee_id' => Employee::factory(),
            'start_date' => $startDate,
            'end_date' => fake()->randomElement([null, $startDate->addYearNoOverflow()]),
            'used_days' => fake()->numberBetween(1, 90),
        ];
    }
}
