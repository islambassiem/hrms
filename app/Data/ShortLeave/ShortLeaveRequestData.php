<?php

declare(strict_types=1);

namespace App\Data\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a short leave request. */
final class ShortLeaveRequestData extends Data
{
    use ShortLeaveRequestValidationRules;

    /** @param int $employee_id The employee identifier. @param int $short_leave_type_id The short leave type identifier. @param CarbonImmutable $short_leave_date The request date. @param string $short_leave_from The start time. @param string $short_leave_to The end time. @param string $status The workflow status. */
    public function __construct(public int $employee_id, public int $short_leave_type_id, public CarbonImmutable $short_leave_date, public string $short_leave_from, public string $short_leave_to, public string $status = 'pending') {}
}
