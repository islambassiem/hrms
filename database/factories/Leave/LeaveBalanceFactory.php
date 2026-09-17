<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Models\Employees\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveBalance>
 */
class LeaveBalanceFactory extends Factory
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
            'leave_type_id' => LeaveType::factory(),
            'available_days' => fake()->numberBetween(1, 10),
            'accrued_days' => fake()->numberBetween(1, 10),
            'used_days' => fake()->numberBetween(1, 10),
            'pending_days' => fake()->numberBetween(1, 10),
            'expiring_days' => fake()->numberBetween(1, 10),
            'next_expiry_date' => fake()->date(),
        ];
    }
}
