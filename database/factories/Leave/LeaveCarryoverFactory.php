<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employees\Employee;
use App\Models\Leave\LeaveCarryover;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveCarryover>
 */
class LeaveCarryoverFactory extends Factory
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
            'from_period_id' => LeavePeriod::factory(),
            'to_period_id' => LeavePeriod::factory(),
            'source_entitlement_id' => LeaveEntitlement::factory(),
            'target_entitlement_id' => LeaveEntitlement::factory(),
            'requested_days' => fake()->numberBetween(0, 70),
            'approved_days' => fake()->numberBetween(0, 70),
            'status' => fake()->randomElement(WorkflowActionEnum::cases()),
            'reason' => fake()->sentence(),
            'requested_by' => Employee::factory(),
            'approved_by' => Employee::factory(),
            'requested_at' => fake()->date(),
            'approved_at' => fake()->date(),
            'expires_at' => fake()->date(),
        ];
    }
}
