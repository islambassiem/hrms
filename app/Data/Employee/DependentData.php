<?php

declare(strict_types=1);

namespace App\Data\Employee;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class DependentData extends Data
{
    public function __construct(
        public int $employee_id,
        public string $identification,
        public int $gender_id,
        public CarbonImmutable $date_of_birth,
        public int $relationship_id,
        public ?string $name_en = null,
        public ?string $name_ar = null,
        public ?bool $has_insurance = false,
        public ?int $ticket_ratio = 0,
    ) {}
}
