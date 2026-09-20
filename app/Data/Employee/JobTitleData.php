<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Concerns\Employee\JobTitleValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class JobTitleData extends Data
{
    use JobTitleValidationRules;

    public function __construct(
        public int $employee_id,
        public int $job_title_id,
        public CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date = null,
    ) {}
}
