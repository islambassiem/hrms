<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeAddress;
use Illuminate\Validation\Rule;

trait AddressValidationRules
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
                'required',
                'integer',
                Rule::exists('employees', 'id'),
                Rule::unique('employee_addresses', 'employee_id'),
            ],
            'short_address' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employee_addresses', 'short_address'),
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
                Rule::unique('employee_addresses', 'employee_id')->ignore($address->id),
            ],
            'short_address' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employee_addresses', 'short_address')->ignore($address->id),
            ],
        ];
    }

    /**
     * @return array<string, string[]>
     */
    public function baseRules(): array
    {
        return [
            'building_number' => ['nullable', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'secondary_number' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
        ];
    }
}
