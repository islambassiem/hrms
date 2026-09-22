<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Leave\LeaveEncashment;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave encashments. */
trait LeaveEncashmentValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'leave_entitlement_id' => ['nullable', 'integer', Rule::exists('leave_entitlements', 'id')], 'days' => ['required', 'numeric', 'gt:0'], 'daily_rate' => ['required', 'numeric', 'min:0'], 'amount' => ['required', 'numeric', 'min:0'], 'status' => ['required', Rule::enum(WorkflowActionEnum::class)], 'reason' => ['nullable', 'string'], 'approved_by' => ['nullable', 'integer', Rule::exists('employees', 'id')], 'approved_at' => ['nullable', Rule::date()], 'processed_at' => ['nullable', Rule::date()], 'payroll_reference' => ['nullable', 'string']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveEncashment $leaveEncashment): array
    {
        return [...self::baseRules()];
    }
}
