<?php

declare(strict_types=1);

namespace App\Concerns\Employee;

use App\Models\Employee\EmployeeJobTitle;
use Illuminate\Validation\Rule;

trait JobTitleValidationRules
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
    public function updateRules(EmployeeJobTitle $jobTitle): array
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

            'job_title_id' => [
                'required',
                'integer',
                Rule::exists('lookup_job_titles', 'id'),
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
