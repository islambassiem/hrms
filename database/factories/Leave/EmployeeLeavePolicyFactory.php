<?php

namespace Database\Factories\Leave;

use App\Models\Employees\Employee;
use App\Models\Leave\EmployeeLeavePolicy;
use App\Models\Leave\LeavePolicy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<EmployeeLeavePolicy>
 */
class EmployeeLeavePolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Date::parse(fake()->date());

        return [
            'employee_id' => Employee::factory(),
            'leave_policy_id' => LeavePolicy::factory(),
            'start_date' => $startDate,
            'end_date' => $startDate->copy()->addYearsNoOverflow(5)->subDay(),
        ];
    }
}
