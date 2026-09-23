<?php

namespace App\Concerns\Payroll;

use App\Models\Payroll\EmployeeBank;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait EmployeeBankValidationRules
{
    /**
     * @phpstan-type ValidationRule string|\Illuminate\Validation\Rules\Exists|\Illuminate\Validation\Rules\Unique|\Illuminate\Validation\Rule
     */

    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),
            'employee_id' => [
                ...$this->employee(),
                Rule::unique('payroll_employee_banks', 'employee_id'),
            ],
            'iban' => [
                ...$this->iban(),
                Rule::unique('payroll_employee_banks', 'iban'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(EmployeeBank $employeeBank): array
    {
        return [
            ...self::baseRules(),
            'employee_id' => [
                ...$this->employee(),
                Rule::unique('payroll_employee_banks', 'employee_id')->ignore($employeeBank->id),
            ],
            'iban' => [
                ...$this->iban(),
                Rule::unique('payroll_employee_banks', 'iban')->ignore($employeeBank->id),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'bank_id' => [
                'required',
                'integer',
                Rule::exists('lookup_payroll_banks', 'id'),
            ],
        ];
    }

    /**
     * @return array<string|Exists>
     */
    private function employee(): array
    {
        return [
            'required',
            'integer',
            Rule::exists('employees', 'id'),
        ];
    }

    /**
     * @return string[]
     */
    private function iban(): array
    {
        return [
            'required',
            'string',
            'max:34',
        ];
    }
}
