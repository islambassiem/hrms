<?php

declare(strict_types=1);

namespace App\Concerns\Payroll;

use App\Models\Payroll\PayslipEarning;
use Illuminate\Validation\Rule;

trait PayslipEarningValidationRules
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
    public function updateRules(PayslipEarning $payslipEarning): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'payslip_id' => [
                'required',
                'integer',
                Rule::exists('payroll_payslips', 'id'),
            ],
            'earning_id' => [
                'required',
                'integer',
                Rule::exists('lookup_payroll_earnings', 'id'),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }
}
