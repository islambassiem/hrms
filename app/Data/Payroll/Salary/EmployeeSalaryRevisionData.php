<?php

declare(strict_types=1);

namespace App\Data\Payroll\Salary;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class EmployeeSalaryRevisionData extends Data
{
    public function __construct(
        public ?int $employee_id,
        public ?int $revision_type_id,
        public ?CarbonImmutable $effective_date,
        public float|int|null $previous_gross = null,
        public float|int|null $new_gross = null,
        public ?string $reason = null,
    ) {}
}
