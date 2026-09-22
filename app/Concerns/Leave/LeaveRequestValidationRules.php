<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Leave\LeaveRequest;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave requests. */
trait LeaveRequestValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'start_date' => ['required', Rule::date()], 'end_date' => ['required', Rule::date()->afterOrEqual('start_date')], 'status' => ['required', Rule::enum(WorkflowActionEnum::class)], 'reason' => ['nullable', 'string']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveRequest $leaveRequest): array
    {
        return [...self::baseRules()];
    }
}
