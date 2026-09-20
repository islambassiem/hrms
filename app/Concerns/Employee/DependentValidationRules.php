<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeDependent;
use Illuminate\Validation\Rule;

trait DependentValidationRules
{
    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return [
            ...self::baseRules(),

            'identification' => [
                ...$this->identification(),
                Rule::unique('employee_dependents', 'identification'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(EmployeeDependent $dependent): array
    {
        return [
            ...self::baseRules(),

            'identification' => [
                ...$this->identification(),
                Rule::unique('employee_dependents', 'identification')
                    ->ignore($dependent->id),
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

            'name_en' => [
                'nullable',
                'string',
                'max:255',
            ],

            'name_ar' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gender_id' => [
                'required',
                'integer',
                Rule::exists('lookup_genders', 'id'),
            ],

            'date_of_birth' => [
                'required',
                Rule::date()->past(),
            ],

            'relationship_id' => [
                'required',
                'integer',
                Rule::exists('lookup_family_relationships', 'id'),
            ],

            'has_insurance' => [
                'required',
                'boolean',
            ],

            'ticket_ratio' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ];
    }

    /**
     * @return string[]
     */
    protected function identification(): array
    {
        return ['required', 'string', 'digits:10'];
    }
}
