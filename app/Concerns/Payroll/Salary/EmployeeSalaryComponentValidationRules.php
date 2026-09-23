<?php

declare(strict_types=1);

namespace App\Concerns\Payroll\Salary;

use App\Models\Payroll\Salary\EmployeeSalaryComponent;
use Illuminate\Validation\Rule;

trait EmployeeSalaryComponentValidationRules
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
    public function updateRules(EmployeeSalaryComponent $component): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'employee_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
            ],
            'component_id' => [
                'required',
                'integer',
                Rule::exists('lookup_payroll_salary_components', 'id'),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'effective_from' => ['required', 'date'],
            'effective_to' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'revision_id' => [
                'nullable',
                'integer',
                Rule::exists('payroll_employee_salary_revisions', 'id'),
            ],
        ];
    }
}
