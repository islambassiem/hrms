<?php

namespace Database\Factories\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeOrganization;
use App\Models\Organization\Organization;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeOrganization>
 */
class EmployeeOrganizationFactory extends Factory
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
            'organization_id' => Organization::factory(),
            'start_date' => $startDate = CarbonImmutable::parse(fake()->date()),
            'end_date' => fake()->randomElement([null, $startDate->addYear()]),
        ];
    }
}
