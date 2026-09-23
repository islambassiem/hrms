<?php

declare(strict_types=1);

namespace App\Data\Payroll;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class PayrollRunData extends Data
{
    public function __construct(
        public ?int $period_id,
        public ?string $run_type,
        public ?CarbonImmutable $run_date,
        public ?string $status,
        public ?int $processed_by,
        public ?int $approved_by,
        public ?CarbonImmutable $approved_at,
        public float|int $total_gross = 0,
        public float|int $total_deductions = 0,
        public float|int $total_net = 0,
    ) {}
}
