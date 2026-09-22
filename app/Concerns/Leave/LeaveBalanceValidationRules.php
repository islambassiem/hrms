<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Models\Leave\LeaveBalance;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave balances. */
trait LeaveBalanceValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'available_days' => ['required', 'numeric', 'min:0'], 'accrued_days' => ['required', 'numeric', 'min:0'], 'used_days' => ['required', 'numeric', 'min:0'], 'pending_days' => ['required', 'numeric', 'min:0'], 'expiring_days' => ['required', 'numeric', 'min:0'], 'next_expiry_date' => ['nullable', Rule::date()]];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeaveBalance $leaveBalance): array
    {
        return [...self::baseRules()];
    }
}
