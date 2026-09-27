<?php

namespace Database\Factories\Employee;

use App\Enums\ContractTypeEnum;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<EmployeeContract>
 */
class EmployeeContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var int $duration */
        $duration = fake()->randomElement([12, 24]);

        return [
            'employee_id' => Employee::factory()->create(),
            'start_date' => $startDate = Date::parse(fake()->date()),
            'duration' => $duration,
            'probation_period' => fake()->randomElement(['90', '180']),
            'notice_period' => fake()->randomElement(['30', '60']),
            'type' => fake()->randomElement(ContractTypeEnum::cases()),
            'end_date' => $startDate->addMonths($duration),
        ];
    }
}
