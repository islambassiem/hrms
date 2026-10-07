<?php

declare(strict_types=1);

namespace App\Data\Employee;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class OrganizationData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $employee_id,
        public int $organization_id,
        public CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date
    ) {
        //
    }
}
