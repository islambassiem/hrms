<?php

namespace Database\Factories\Employees;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeAddress>
 */
class EmployeeAddressFactory extends Factory
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
            'short_address' => mb_strtoupper(fake()->lexify()).fake()->numerify('####'),
            'building_number' => fake()->optional()->numerify('####'),
            'street' => fake()->optional()->streetAddress(),
            'secondary_number' => fake()->optional()->numerify('####'),
            'district' => fake()->optional()->streetName(),
            'postal_code' => fake()->optional()->numerify('####'),
            'city' => fake()->optional()->city(),
        ];
    }
}
