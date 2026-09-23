<?php

declare(strict_types=1);

namespace App\Data\Payroll;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class PeriodData extends Data
{
    public function __construct(
        public ?string $name,
        public ?CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date,
        public ?CarbonImmutable $pay_date,
        public ?string $status,
    ) {}
}
