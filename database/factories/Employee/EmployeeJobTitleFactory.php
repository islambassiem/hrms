<?php

declare(strict_types=1);

namespace Database\Factories\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\JobTitle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<EmployeeJobTitle>
 */
class EmployeeJobTitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'job_title_id' => JobTitle::factory(),
            'start_date' => $startDate = Date::parse(fake()->date()),
            'end_date' => fake()->randomElement([null, $startDate->addYears(random_int(2, 5))]),
        ];
    }
}
