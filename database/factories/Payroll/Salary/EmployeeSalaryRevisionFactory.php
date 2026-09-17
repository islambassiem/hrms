<?php

declare(strict_types=1);

namespace Database\Factories\Payroll\Salary;

use App\Models\Employees\Employee;
use App\Models\Lookup\SalaryRevision;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmployeeSalaryRevision>
 */
class EmployeeSalaryRevisionFactory extends Factory
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
            'revision_type_id' => SalaryRevision::factory(),
            'effective_date' => fake()->date(),
            'previous_gross' => fake()->numberBetween(400000),
            'new_gross' => fake()->numberBetween(600000),
            'reason' => fake()->sentence(),
        ];
    }
}
