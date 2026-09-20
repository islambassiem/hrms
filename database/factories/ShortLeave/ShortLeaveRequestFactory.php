<?php

declare(strict_types=1);

namespace Database\Factories\ShortLeave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<ShortLeaveRequest>
 */
class ShortLeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $from = Date::parse(fake()->date('H:i:s'));

        return [
            'employee_id' => Employee::factory(),
            'short_leave_type_id' => ShortLeaveType::factory(),
            'short_leave_date' => fake()->date(),
            'short_leave_from' => $from->format('H:i:m'),
            'short_leave_to' => $from->addHours(3),
            'status' => fake()->randomElement(WorkflowActionEnum::cases()),
        ];
    }
}
