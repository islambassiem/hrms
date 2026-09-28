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

        /** @var WorkflowActionEnum $status */
        $status = fake()->randomElement(WorkflowActionEnum::cases());

        return [
            'leave_type_id' => $typeIds->random(),
            'employee_id' => $employeeIds->random(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'no_of_days' => (int) $startDate->diffInDays($endDate) + 1,
            'status' => $status->value,
            'reason' => fake()->optional()->sentence(),
        ];
    }
}
