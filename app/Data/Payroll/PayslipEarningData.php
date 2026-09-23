<?php

declare(strict_types=1);

namespace App\Data\Payroll;

use Spatie\LaravelData\Data;

final class PayslipEarningData extends Data
{
    public function __construct(
        public ?int $payslip_id,
        public ?int $earning_id,
        public float|int|null $amount,
        public ?string $description = null,
    ) {}
}
