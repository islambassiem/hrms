<?php

namespace App\Concerns\Qualification;

use App\Models\Qualifications\Qualification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait QualificationValidationRules
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
            'employee_id' => $this->employee(),
            'major_id' => $this->major(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(Qualification $qualification): array
    {
        return [
            ...self::baseRules(),
            'employee_id' => $this->employee(),
            'major_id' => $this->major(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'minor_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_specialities', 'id')],
            'educational_sublevel_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_educational_sublevels', 'id')],
            'included_specialty_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_included_specializations', 'id')],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'college_name' => ['nullable', 'string', 'max:255'],
            'scientific_degree_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_scientific_degrees', 'id')],
            'graduation_date' => ['nullable', 'date'],
            'graduation_country_id' => ['nullable', 'integer', Rule::exists('lookup_countries', 'id')],
            'is_last_qualification' => ['nullable', 'boolean'],
            'rating_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_ratings', 'id')],
            'gpa' => ['nullable', 'string', 'max:255'],
            'gpa_type_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_gpa_types', 'id')],
            'study_type_id' => ['nullable', 'integer', Rule::exists('lookup_qualifications_study_types', 'id')],
            'city' => ['nullable', 'string', 'max:255'],
            'is_authenticated' => ['nullable', 'boolean'],
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
    private function major(): array
    {
        return [
            'required',
            'integer',
            Rule::exists('lookup_qualifications_specialities', 'id'),
        ];
    }
}
