<?php

namespace App\Concerns\Payroll;

use App\Models\Payroll\PayrollPayslip;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait PayslipValidationRules
{
    /**
     * @phpstan-type ValidationRule string|\Illuminate\Validation\Rules\Exists|\Illuminate\Validation\Rules\Unique|\Illuminate\Validation\Rule
     */

    /**
     * @return array<string, mixed>
     */
    public function createRules(?int $runId = null): array
    {
        return [
            ...self::baseRules(),
            'run_id' => $this->run(),
            'employee_id' => [
                ...$this->employee(),
                Rule::unique('payroll_payslips', 'employee_id')->where('run_id', $runId),
            ],
            'salary_revision_id' => $this->salaryRevision(),
            'status' => $this->status(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(PayrollPayslip $payslip, ?int $runId = null): array
    {
        return [
            ...self::baseRules(),
            'run_id' => $this->run(),
            'employee_id' => [
                ...$this->employee(),
                Rule::unique('payroll_payslips', 'employee_id')
                    ->where('run_id', $runId ?? $payslip->run_id)
                    ->ignore($payslip->id),
            ],
            'salary_revision_id' => $this->salaryRevision(),
            'status' => $this->status(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'days_worked' => ['nullable', 'integer', 'min:0'],
            'gross_earnings' => ['nullable', 'numeric', 'min:0'],
            'total_deductions' => ['nullable', 'numeric', 'min:0'],
            'net_pay' => ['nullable', 'numeric', 'min:0'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string|Exists>
     */
    private function run(): array
    {
        return [
            'required',
            'integer',
            Rule::exists('payroll_runs', 'id'),
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
     * @return array<string|Exists>
     */
    private function salaryRevision(): array
    {
        return [
            'required',
            'integer',
            Rule::exists('payroll_employee_salary_revisions', 'id'),
        ];
    }

    /**
     * @return string[]
     */
    private function status(): array
    {
        return [
            'required',
            'string',
            'max:255',
        ];
    }
}
