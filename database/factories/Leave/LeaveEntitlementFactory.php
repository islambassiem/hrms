<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\LeaveEntitlementEnum;
use App\Models\Employees\Employee;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveEntitlement>
 */
class LeaveEntitlementFactory extends Factory
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
            'leave_policy_id' => LeavePolicy::factory(),
            'leave_period_id' => LeavePeriod::factory(),
            'entitled_days' => fake()->numberBetween(0, 30),
            'accrued_days' => fake()->numberBetween(0, 30),
            'used_days' => fake()->numberBetween(0, 30),
            'expired_days' => fake()->numberBetween(0, 30),
            'encashed_days' => fake()->numberBetween(0, 30),
            'expires_at' => fake()->date(),
            'status' => fake()->randomElement(LeaveEntitlementEnum::cases()),
        ];
    }
}
