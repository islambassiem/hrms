<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveRequestValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave request. */
final class LeaveRequestData extends Data
{
    use LeaveRequestValidationRules;

    /** @param int $leave_type_id The leave type identifier. @param int $employee_id The employee identifier. @param CarbonImmutable $start_date The leave start date. @param CarbonImmutable $end_date The leave end date. @param string $status The workflow status. @param string|null $reason The optional reason. */
    public function __construct(public int $leave_type_id, public int $employee_id, public CarbonImmutable $start_date, public CarbonImmutable $end_date, public string $status = 'pending', public ?string $reason = null) {}
}
