<?php

declare(strict_types=1);

namespace App\Concerns\Payroll\Salary;

use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Validation\Rule;

trait EmployeeSalaryRevisionValidationRules
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
    public function updateRules(EmployeeSalaryRevision $revision): array
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
            'revision_type_id' => [
                'required',
                'integer',
                Rule::exists('lookup_payroll_salary_revisions', 'id'),
            ],
            'effective_date' => ['required', 'date'],
            'previous_gross' => ['nullable', 'numeric', 'min:0'],
            'new_gross' => ['required', 'numeric', 'min:0'],
            'reason' => ['required', 'string', 'max:255'],
        ];
    }
}
