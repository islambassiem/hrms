<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveBalanceValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave balance. */
final class LeaveBalanceData extends Data
{
    use LeaveBalanceValidationRules;

    /** @param int $employee_id @param int $leave_type_id @param float $available_days @param float $accrued_days @param float $used_days @param float $pending_days @param float $expiring_days @param CarbonImmutable|null $next_expiry_date */
    public function __construct(public int $employee_id, public int $leave_type_id, public float $available_days = 0.0, public float $accrued_days = 0.0, public float $used_days = 0.0, public float $pending_days = 0.0, public float $expiring_days = 0.0, public ?CarbonImmutable $next_expiry_date = null) {}
}
