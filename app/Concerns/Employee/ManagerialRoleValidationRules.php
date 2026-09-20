<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeManagerialRole;
use Illuminate\Validation\Rule;

trait ManagerialRoleValidationRules
{
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
    public function updateRules(EmployeeManagerialRole $managerialRole): array
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

            'managerial_role_id' => [
                'required',
                'integer',
                Rule::exists('lookup_managerial_roles', 'id'),
            ],

            'start_date' => [
                'required',
                Rule::date(),
            ],

            'end_date' => [
                'nullable',
                Rule::date()->after('start_date'),
            ],
        ];
    }
}
