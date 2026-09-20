<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeAddress;
use Illuminate\Validation\Rule;

trait AddressValidationRules
{
    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),

            'employee_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
                Rule::unique('employee_addresses', 'employee_id'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(EmployeeAddress $address): array
    {
        return [
            ...self::baseRules(),

            'employee_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
                Rule::unique('employee_addresses', 'employee_id')
                    ->ignore($address->id),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'short_address' => [
                'required',
                'string',
                'max:255',
            ],

            'building_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'street' => [
                'nullable',
                'string',
                'max:255',
            ],

            'secondary_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'district' => [
                'nullable',
                'string',
                'max:255',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
