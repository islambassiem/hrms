<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\Employee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait EmployeeValidationRules
{
    /**
     * @return array<string, array<mixed>|ValidationRule|string>
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),

            'user_id' => [
                ...$this->user(),
                Rule::unique('employees', 'user_id'),
            ],

            'employee_code' => [
                $this->employeeCode(),
                Rule::unique('employees', 'employee_code'),
            ],

            'email' => [
                ...$this->email(),
                Rule::unique('employees', 'email'),
            ],
        ];
    }

    /**
     * @return array<string, array<mixed>|ValidationRule|string>
     */
    public function updateRules(Employee $employee): array
    {
        return [
            ...self::baseRules(),

            'user_id' => [
                ...$this->user(),
                Rule::unique('employees', 'user_id')
                    ->ignore($employee->id),
            ],

            'employee_code' => [
                ...$this->employeeCode(),
                Rule::unique('employees', 'employee_code')
                    ->ignore($employee->id),
            ],

            'email' => [
                ...$this->email(),
                Rule::unique('employees', 'email')
                    ->ignore($employee->id),
            ],
        ];
    }

    /**
     * @return array<string, array<mixed>|ValidationRule|string>
     */
    public function baseRules(): array
    {
        return [
            'head_id' => [
                'nullable',
                Rule::exists('employees', 'id'),
            ],

            'first_name_ar' => [
                'required',
                'string',
                'max:30',
            ],

            'middle_name_ar' => [
                'nullable',
                'string',
                'max:30',
            ],

            'third_name_ar' => [
                'nullable',
                'string',
                'max:30',
            ],

            'last_name_ar' => [
                'required',
                'string',
                'max:30',
            ],

            'first_name_en' => [
                'required',
                'string',
                'max:30',
            ],

            'middle_name_en' => [
                'nullable',
                'string',
                'max:30',
            ],

            'third_name_en' => [
                'nullable',
                'string',
                'max:30',
            ],

            'last_name_en' => [
                'required',
                'string',
                'max:30',
            ],

            'gender_id' => [
                'required',
                Rule::exists('lookup_genders', 'id'),
            ],

            'category_id' => [
                'required',
                Rule::exists('lookup_categories', 'id'),
            ],

            'department_id' => [
                'required',
                Rule::exists('lookup_departments', 'id'),
            ],

            'nationality_id' => [
                'required',
                Rule::exists('lookup_countries', 'id'),
            ],

            'place_of_birth_id' => [
                'nullable',
                Rule::exists('lookup_countries', 'id'),
            ],

            'marital_status_id' => [
                'nullable',
                Rule::exists('lookup_marital_statuses', 'id'),
            ],

            'religion_id' => [
                'nullable',
                Rule::exists('lookup_religions', 'id'),
            ],

            'special_need_id' => [
                'nullable',
                Rule::exists('lookup_special_needs', 'id'),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'image' => [
                'nullable',
                'string',
                'max:255',
            ],

            'date_of_birth' => [
                'required',
                Rule::date()->nowOrPast(),
            ],

            'joining_date' => [
                'required',
                Rule::date()->nowOrFuture(),
            ],

            'leaving_date' => [
                'nullable',
                Rule::date()->after('joining_date'),
            ],

            'home_telephone_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'home_country_identity' => [
                'nullable',
                'string',
                'max:30',
            ],

            'blood_type' => [
                'nullable',
                'string',
                'max:30',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * @return array<int, Exists|string>
     */
    private function user(): array
    {
        return [
            'required',
            Rule::exists('users', 'id'),
        ];
    }

    /**
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    private function employeeCode(): array
    {
        return [
            'required',
            'string',
            'max:30',
        ];
    }

    /**
     * @return array<int, ValidationRule|array<mixed>|string>
     */
    private function email(): array
    {
        return [
            'required',
            'email',
            'max:255',
        ];
    }
}
