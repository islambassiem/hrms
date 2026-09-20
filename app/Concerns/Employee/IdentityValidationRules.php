<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeIdentity;
use Illuminate\Validation\Rule;

trait IdentityValidationRules
{
    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),

            'identity_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employee_identities', 'identity_number'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(EmployeeIdentity $identity): array
    {
        return [
            ...self::baseRules(),

            'identity_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employee_identities', 'identity_number')
                    ->ignore($identity->id),
            ],
        ];
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

            'identity_type_id' => [
                'required',
                'integer',
                Rule::exists('lookup_identity_types', 'id'),
            ],

            'place_of_issue' => [
                'nullable',
                'string',
                'max:255',
            ],

            'issue_date' => [
                'nullable',
                Rule::date()->nowOrPast(),
            ],

            'expiry_date' => [
                'nullable',
                Rule::date()->after('issue_date'),
            ],
        ];
    }
}
