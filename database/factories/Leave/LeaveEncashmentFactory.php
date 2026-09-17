<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employees\Employee;
use App\Models\Leave\LeaveEncashment;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveEncashment>
 */
class LeaveEncashmentFactory extends Factory
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
            'leave_entitlement_id' => LeaveEntitlement::factory(),
            'days' => fake()->numberBetween(1, 30),
            'daily_rate' => fake()->numberBetween(300, 3000),
            'amount' => fake()->numberBetween(300, 3000) * fake()->numberBetween(1, 30) / 30,
            'status' => fake()->randomElement(WorkflowActionEnum::cases()),
            'reason' => fake()->sentence(),
            'approved_by' => Employee::factory(),
            'approved_at' => fake()->date(),
            'processed_at' => fake()->date(),
            'payroll_reference' => fake()->word(),
        ];
    }
}
