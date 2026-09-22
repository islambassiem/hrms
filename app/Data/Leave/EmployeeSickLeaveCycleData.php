<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\EmployeeSickLeaveCycleValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for an employee sick leave cycle. */
final class EmployeeSickLeaveCycleData extends Data
{
    use EmployeeSickLeaveCycleValidationRules;

    /** @param int $employee_id The employee identifier. @param CarbonImmutable $start_date The cycle start date. @param CarbonImmutable|null $end_date The optional cycle end date. @param int $used_days The used sick leave days. */
    public function __construct(public int $employee_id, public CarbonImmutable $start_date, public ?CarbonImmutable $end_date = null, public int $used_days = 0) {}
}
