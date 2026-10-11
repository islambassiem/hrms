<?php

declare(strict_types=1);

namespace App\Services\Employee;

class QualificationFormData
{
    /**
     * @return array<string, mixed>
     */
    public function dropdowns(): array
    {
        return [
            'educational_sublevel_id' => [],
            'major_id' => [],
            'minor_id' => [],
            'educational_sub_level_id' => [],
            'included_specialty_id' => [],
            'scientific_degree_id' => [],
            'graduation_country_id' => [],
            'rating_id' => [],
            'gpa_type_id' => [],
            'study_type_id' => [],
        ];
    }
}
