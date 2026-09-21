<?php

declare(strict_types=1);

namespace App\Concerns\Leave;

use App\Models\Leave\EmployeeLeavePolicy;
use Illuminate\Validation\Rule;

/**
 * Provides validation rules for employee leave policy assignments.
 */
trait EmployeeLeavePolicyValidationRules
{
    /**
     * Get validation rules shared by employee leave policy creation and updates.
     *
     * @return array<string, mixed> The shared validation rules keyed by attribute name.
     */
    public function baseRules(): array
    {
        return [
            'employee_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
            ],

            'leave_policy_id' => [
                'required',
                'integer',
                Rule::exists('leave_policies', 'id'),
            ],

            'start_date' => [
                'required',
                Rule::date(),
            ],

            'end_date' => [
                'nullable',
                Rule::date()->afterOrEqual('start_date'),
            ],
        ];
    }

    /**
     * Get validation rules for creating an employee leave policy assignment.
     *
     * @return array<string, mixed> The creation validation rules keyed by attribute name.
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),
        ];
    }

    /**
     * Get validation rules for updating an employee leave policy assignment.
     *
     * @param  EmployeeLeavePolicy  $employeeLeavePolicy  The assignment being updated.
     * @return array<string, mixed> The update validation rules keyed by attribute name.
     */
    public function updateRules(EmployeeLeavePolicy $employeeLeavePolicy): array
    {
        return [
            ...self::baseRules(),
        ];
    }
}
