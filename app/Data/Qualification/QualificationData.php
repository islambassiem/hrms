<?php

declare(strict_types=1);

namespace App\Data\Qualification;

use Spatie\LaravelData\Data;

class QualificationData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?int $employee_id,
        public ?int $major_id,
        public ?int $minor_id = null,
        public ?int $educational_sublevel_id = null,
        public ?int $included_specialty_id = null,
        public ?string $institution_name = null,
        public ?string $college_name = null,
        public ?int $scientific_degree_id = null,
        public ?string $graduation_date = null,
        public ?int $graduation_country_id = null,
        public bool $is_last_qualification = false,
        public ?int $rating_id = null,
        public ?string $gpa = null,
        public ?int $gpa_type_id = null,
        public ?int $study_type_id = null,
        public ?string $city = null,
        public bool $is_authenticated = false,
    ) {
        //
    }
}
