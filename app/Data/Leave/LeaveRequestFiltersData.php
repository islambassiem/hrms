<?php

declare(strict_types=1);

namespace App\Data\Leave;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class LeaveRequestFiltersData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        /** @var int[]|null */
        public ?array $employeeIds = null,

        /** @var int[]|null */
        public ?array $leaveTypeIds = null,

        /** @var int[]|null */
        public ?array $departmentIds = null,

        /** @var int[]|null */
        public ?array $genderIds = null,

        /** @var string[]|null */
        public ?array $statuses = null,

        public ?CarbonImmutable $startDate = null,

        public ?CarbonImmutable $endDate = null
    ) {
        //
    }
}
