<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Leave\LeaveCarryover;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave carryovers. */
trait LeaveCarryoverValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'from_period_id' => ['required', 'integer', Rule::exists('leave_periods', 'id')], 'to_period_id' => ['required', 'integer', Rule::exists('leave_periods', 'id'), 'different:from_period_id'], 'source_entitlement_id' => ['nullable', 'integer', Rule::exists('leave_entitlements', 'id')], 'target_entitlement_id' => ['nullable', 'integer', Rule::exists('leave_entitlements', 'id')], 'requested_days' => ['required', 'numeric', 'min:0'], 'approved_days' => ['required', 'numeric', 'min:0'], 'status' => ['required', Rule::enum(WorkflowActionEnum::class)], 'reason' => ['nullable', 'string'], 'requested_by' => ['nullable', 'integer', Rule::exists('employees', 'id')], 'approved_by' => ['nullable', 'integer', Rule::exists('employees', 'id')], 'requested_at' => ['nullable', Rule::date()], 'approved_at' => ['nullable', Rule::date()], 'expires_at' => ['nullable', Rule::date()]];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveCarryover $leaveCarryover): array
    {
        return [...self::baseRules()];
    }
}
