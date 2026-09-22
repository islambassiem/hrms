<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\LeaveTransactionTypeEnum;
use App\Models\Leave\LeaveTransaction;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave transactions. */
trait LeaveTransactionValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'leave_entitlement_id' => ['nullable', 'integer', Rule::exists('leave_entitlements', 'id')], 'leave_request_id' => ['nullable', 'integer', Rule::exists('leave_requests', 'id')], 'transaction_type' => ['required', Rule::enum(LeaveTransactionTypeEnum::class)], 'days' => ['required', 'numeric'], 'transaction_date' => ['required', Rule::date()], 'start_date' => ['nullable', Rule::date()], 'end_date' => ['nullable', Rule::date()->afterOrEqual('start_date')], 'balance_after' => ['nullable', 'numeric', 'min:0'], 'pay_rate' => ['nullable', 'numeric', 'min:0'], 'expires_at' => ['nullable', Rule::date()], 'payroll_processed_at' => ['nullable', Rule::date()], 'reference_type' => ['nullable', 'string'], 'reference_id' => ['nullable', 'integer']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveTransaction $leaveTransaction): array
    {
        return [...self::baseRules()];
    }
}
