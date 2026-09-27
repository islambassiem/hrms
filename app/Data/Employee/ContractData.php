<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Enums\ContractTypeEnum;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class ContractData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $employee_id,
        public CarbonImmutable $start_date,
        public int $duration,
        public int $probation_period,
        public int $notice_period,
        public ContractTypeEnum $type,
        public CarbonImmutable $end_date,
    ) {
        //
    }
}
