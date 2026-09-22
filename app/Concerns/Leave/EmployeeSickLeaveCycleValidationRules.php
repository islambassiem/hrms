<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Models\Leave\EmployeeSickLeaveCycle;
use Illuminate\Validation\Rule;

/** Provides validation rules for employee sick leave cycles. */
trait EmployeeSickLeaveCycleValidationRules
{
    /** @return array<string, mixed> */
    public function baseRules(): array
    {
        return ['employee_id' => ['required', 'integer', Rule::exists('employees', 'id')], 'start_date' => ['required', Rule::date()], 'end_date' => ['nullable', Rule::date()->afterOrEqual('start_date')], 'used_days' => ['required', 'integer', 'min:0']];
    }

    /** @return array<string, mixed> */
    public function createRules(): array
    {
        return [...self::baseRules()];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(EmployeeSickLeaveCycle $employeeSickLeaveCycle): array
    {
        return [...self::baseRules()];
    }
}
