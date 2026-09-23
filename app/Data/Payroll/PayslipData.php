<?php

declare(strict_types=1);

namespace App\Data\Payroll;

use Spatie\LaravelData\Data;

final class PayslipData extends Data
{
    public function __construct(
        public ?int $run_id,
        public ?int $employee_id,
        public ?int $salary_revision_id,
        public ?int $days_worked = null,
        public float|int $gross_earnings = 0,
        public float|int $total_deductions = 0,
        public float|int $net_pay = 0,
        public ?string $status = null,
        public ?string $remarks = null,
    ) {}
}
