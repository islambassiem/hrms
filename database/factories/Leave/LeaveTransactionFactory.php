<?php

namespace Database\Factories\Leave;

use App\Enums\LeaveTransactionTypeEnum;
use App\Models\Employees\Employee;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeaveRequest;
use App\Models\Leave\LeaveTransaction;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<LeaveTransaction>
 */
class LeaveTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var string|null $fakeDate */
        $fakeDate = fake()->optional()->date();
        $startDate = $fakeDate !== null ? Date::parse($fakeDate) : null;
        $days = fake()->randomDigit();
        $endDate = $startDate?->copy()->addDays($days);

        return [
            'employee_id' => Employee::factory(),
            'leave_type_id' => LeaveType::factory(),
            'leave_entitlement_id' => LeaveEntitlement::factory(),
            'leave_request_id' => LeaveRequest::factory(),
            'transaction_type' => fake()->randomElement(LeaveTransactionTypeEnum::cases()),
            'days' => $days,
            'transaction_date' => fake()->date(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'balance_after' => fake()->numberBetween(0, 60),
            'pay_rate' => fake()->randomElement([0, 50, 100]),
            'expires_at' => fake()->date(),
            'payroll_processed_at' => fake()->date(),
            'reference_type' => fake()->optional()->word(),
            'reference_id' => fake()->numberBetween(),
        ];
    }
}
