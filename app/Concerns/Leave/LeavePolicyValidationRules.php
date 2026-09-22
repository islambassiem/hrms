<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\AccrualFrequencyEnum;
use App\Enums\YearTypeEnum;
use App\Models\Leave\LeavePolicy;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave policies. */
trait LeavePolicyValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['leave_type_id' => ['required', 'integer', Rule::exists('lookup_leave_types', 'id')], 'name_en' => ['required', 'string', 'max:255'], 'name_ar' => ['required', 'string', 'max:255'], 'days_per_year' => ['required', 'numeric', 'min:0'], 'is_default' => ['required', 'boolean'], 'accrual_frequency' => ['required', Rule::enum(AccrualFrequencyEnum::class)], 'period_type' => ['required', Rule::enum(YearTypeEnum::class)], 'allow_accumulation' => ['required', 'boolean'], 'accumulation_periods' => ['required', 'integer', 'min:1', 'max:255'], 'allow_management_carryover' => ['required', 'boolean'], 'expire_unused' => ['required', 'boolean'], 'encash_on_termination' => ['required', 'boolean'], 'pay_rate' => ['nullable', 'numeric', 'min:0']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeavePolicy $leavePolicy): array
    {
        return [...self::baseRules()];
    }
}
