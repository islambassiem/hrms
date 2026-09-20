<?php

declare(strict_types=1);

namespace Database\Factories\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typeIds = LeaveType::query()->pluck('id');
        $employeeIds = Employee::query()->pluck('id');
        $startDate = Date::parse(fake()->date());
        $endDate = $startDate->addDays(fake()->randomDigit() + 1);

        return [
            'leave_type_id' => $typeIds->random(),
            'employee_id' => $employeeIds->random(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => fake()->randomElement(WorkflowActionEnum::cases()),
            'reason' => fake()->optional()->sentence(),
        ];
    }
}
