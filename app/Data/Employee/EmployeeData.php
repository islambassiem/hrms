<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Concerns\Employee\EmployeeValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class EmployeeData extends Data
{
    use EmployeeValidationRules;

    public function __construct(
        public ?int $user_id,
        public ?int $head_id,
        public string $employee_code,
        public string $first_name_ar,
        public ?string $middle_name_ar,
        public ?string $third_name_ar,
        public string $last_name_ar,
        public string $first_name_en,
        public ?string $middle_name_en,
        public ?string $third_name_en,
        public string $last_name_en,
        public int $gender_id,
        public int $nationality_id,
        public int $category_id,
        public int $department_id,
        public ?int $marital_status_id = null,
        public ?int $religion_id = null,
        public ?int $special_need_id = null,
        public ?int $place_of_birth_id = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $image = null,
        public ?CarbonImmutable $date_of_birth = null,
        public ?CarbonImmutable $joining_date = null,
        public ?CarbonImmutable $leaving_date = null,
        public ?string $home_telephone_number = null,
        public ?string $home_country_identity = null,
        public ?string $blood_type = null,
        public bool $is_active = true,
    ) {}
}
