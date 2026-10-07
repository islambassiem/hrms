<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use Illuminate\Validation\Rule;

trait OrganizationValidationRules
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
    public function updateRules(): array
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
            'organization_id' => [
                'required',
                'integer',
                Rule::exists('organizations', 'id'),
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
