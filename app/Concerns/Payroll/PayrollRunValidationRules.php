<?php

declare(strict_types=1);

namespace App\Concerns\Payroll;

use App\Models\Payroll\PayrollRun;
use Illuminate\Validation\Rule;

trait PayrollRunValidationRules
{
    /**
     * @phpstan-type ValidationRule string|\Illuminate\Validation\Rules\Exists|\Illuminate\Validation\Rules\Unique|\Illuminate\Validation\Rule
     */

    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(PayrollRun $run): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'period_id' => [
                'required',
                'integer',
                Rule::exists('payroll_periods', 'id'),
            ],
            'run_type' => ['required', 'string', 'max:255'],
            'run_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:255'],
            'processed_by' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
            ],
            'approved_by' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
            ],
            'approved_at' => ['required', 'date'],
            'total_gross' => ['nullable', 'numeric', 'min:0'],
            'total_deductions' => ['nullable', 'numeric', 'min:0'],
            'total_net' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
