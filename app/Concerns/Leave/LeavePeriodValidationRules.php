<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Enums\YearTypeEnum;
use App\Models\Leave\LeavePeriod;
use Illuminate\Validation\Rule;

/** Provides validation rules for leave periods. */
trait LeavePeriodValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['name_en' => ['required', 'string', 'max:255'], 'name_ar' => ['required', 'string', 'max:255'], 'code' => ['nullable', 'string', 'max:255'], 'type' => ['required', Rule::enum(YearTypeEnum::class)], 'start_date' => ['required', Rule::date()], 'end_date' => ['required', Rule::date()->afterOrEqual('start_date')], 'is_closed' => ['required', 'boolean']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules(), 'code' => ['nullable', 'string', 'max:255', Rule::unique('leave_periods', 'code')]];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(LeavePeriod $leavePeriod): array
    {
        return [...self::baseRules(), 'code' => ['nullable', 'string', 'max:255', Rule::unique('leave_periods', 'code')->ignore($leavePeriod->id)]];
    }
}
