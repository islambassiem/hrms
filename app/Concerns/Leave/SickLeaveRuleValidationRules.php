<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Models\Leave\SickLeaveRule;
use Illuminate\Validation\Rule;

/** Provides validation rules for sick leave rules. */
trait SickLeaveRuleValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['no_of_days' => ['required', 'integer', 'min:1'], 'pay_rate' => ['required', 'numeric', 'min:0'], 'effective_from' => ['required', Rule::date()], 'effective_to' => ['nullable', Rule::date()->afterOrEqual('effective_from')]];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(SickLeaveRule $sickLeaveRule): array
    {
        return [...self::baseRules()];
    }
}
