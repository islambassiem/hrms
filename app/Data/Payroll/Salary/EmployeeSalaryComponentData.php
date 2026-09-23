<?php

declare(strict_types=1);

namespace App\Data\Payroll\Salary;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class EmployeeSalaryComponentData extends Data
{
    public function __construct(
        public ?int $employee_id,
        public ?int $component_id,
        public float|int|null $amount,
        public ?CarbonImmutable $effective_from,
        public ?CarbonImmutable $effective_to = null,
        public ?int $revision_id = null,
    ) {}
}
