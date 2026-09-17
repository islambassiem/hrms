<?php

declare(strict_types=1);

namespace Database\Factories\Employees;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeJobTitle;
use App\Models\Lookup\JobTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'start_date' => fake()->date(),
            'end_date' => fake()->optional()->date(),
        ];
    }
}
