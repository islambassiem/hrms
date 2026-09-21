<?php

declare(strict_types=1);

namespace App\Concerns\ShortLeave;

use App\Enums\WorkflowActionEnum;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Validation\Rule;

/** Provides validation rules for short leave requests. */
trait ShortLeaveRequestValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'short_leave_type_id' => ['required', 'integer', Rule::exists('lookup_short_leave_types', 'id')], 'short_leave_date' => ['required', Rule::date()], 'short_leave_from' => ['required', 'date_format:H:i:s'], 'short_leave_to' => ['required', 'date_format:H:i:s', 'after:short_leave_from'], 'status' => ['required', Rule::enum(WorkflowActionEnum::class)]];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(ShortLeaveRequest $shortLeaveRequest): array
    {
        return [...self::baseRules()];
    }
}
