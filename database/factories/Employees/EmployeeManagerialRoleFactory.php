<?php

declare(strict_types=1);

namespace Database\Factories\Employees;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeManagerialRole;
use App\Models\Lookup\ManagerialRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeManagerialRole>
 */
class EmployeeManagerialRoleFactory extends Factory
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
            'managerial_role_id' => ManagerialRole::factory(),
            'start_date' => fake()->date(),
            'end_date' => fake()->optional()->date(),
        ];
    }
}
