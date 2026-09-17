<?php

namespace Database\Factories\Employees;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeIdentity;
use App\Models\Lookup\IdentityType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<EmployeeIdentity>
 */
class EmployeeIdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $issueDate = Date::parse(fake()->date());

        return [
            'employee_id' => Employee::factory(),
            'identity_type_id' => IdentityType::factory(),
            'identity_number' => fake()->unique()->numerify('##########'),
            'place_of_issue' => fake()->city(),
            'issue_date' => $issueDate,
            'expiry_date' => $issueDate->addYears(5),
        ];
    }
}
