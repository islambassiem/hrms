<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\LeaveEntitlementEnum;
use App\Models\Leave\LeaveEntitlement;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave entitlements. */
trait LeaveEntitlementValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'leave_policy_id' => ['required', 'integer', Rule::exists('leave_policies', 'id')], 'leave_period_id' => ['required', 'integer', Rule::exists('leave_periods', 'id')], 'entitled_days' => ['required', 'numeric', 'min:0'], 'accrued_days' => ['required', 'numeric', 'min:0'], 'used_days' => ['required', 'numeric', 'min:0'], 'expired_days' => ['required', 'numeric', 'min:0'], 'encashed_days' => ['required', 'numeric', 'min:0'], 'expires_at' => ['nullable', Rule::date()], 'status' => ['required', Rule::enum(LeaveEntitlementEnum::class)]];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),
            'leave_policy_id' => [
                'required',
                'integer',
                Rule::exists('leave_policies', 'id'),
                Rule::unique('leave_entitlements', 'leave_policy_id')->where(
                    fn (Builder $query): Builder => $query
                        ->where('employee_id', request('employee_id'))
                        ->where('leave_period_id', request('leave_period_id'))
                ),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveEntitlement $leaveEntitlement): array
    {
        return [
            ...self::baseRules(),
            'leave_policy_id' => [
                'required',
                'integer',
                Rule::exists('leave_policies', 'id'),
                Rule::unique('leave_entitlements', 'leave_policy_id')->where(
                    fn (Builder $query): Builder => $query
                        ->where('employee_id', request('employee_id'))
                        ->where('leave_period_id', request('leave_period_id'))
                )->ignore($leaveEntitlement->id),
            ],
        ];
    }
}
