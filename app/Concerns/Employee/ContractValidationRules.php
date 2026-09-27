<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Enums\ContractTypeEnum;
use Illuminate\Validation\Rule;

trait ContractValidationRules
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'integer', Rule::exists('employees', 'id')],
            'salary_revision_id' => ['required', 'integer', Rule::exists('payroll_employee_salary_revisions', 'id')],
            'address_id' => ['required', 'integer', Rule::exists('employee_addresses', 'id')],
            'start_date' => ['required', Rule::date()],
            'duration' => ['required', 'integer'],
            'probation_period' => ['required', 'integer'],
            'notice_period' => ['required', 'integer'],
            'type' => ['required', Rule::enum(ContractTypeEnum::class)],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }
}
