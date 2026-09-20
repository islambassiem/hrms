<?php

declare(strict_types=1);

namespace Database\Factories\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeManagerialRole;
use App\Models\Lookup\ManagerialRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

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
            'start_date' => $startDate = Date::parse(fake()->date()),
            'end_date' => fake()->randomElement([null, $startDate->addYears(random_int(1, 5))]),
        ];
    }
}
