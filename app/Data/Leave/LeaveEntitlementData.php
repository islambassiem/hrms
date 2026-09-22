<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveEntitlementValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave entitlement. */
final class LeaveEntitlementData extends Data
{
    use LeaveEntitlementValidationRules;

    /** @param int $employee_id @param int $leave_type_id @param int $leave_policy_id @param int $leave_period_id @param float $entitled_days @param float $accrued_days @param float $used_days @param float $expired_days @param float $encashed_days @param CarbonImmutable|null $expires_at @param string $status */
    public function __construct(public int $employee_id, public int $leave_type_id, public int $leave_policy_id, public int $leave_period_id, public float $entitled_days = 0.0, public float $accrued_days = 0.0, public float $used_days = 0.0, public float $expired_days = 0.0, public float $encashed_days = 0.0, public ?CarbonImmutable $expires_at = null, public string $status = 'active') {}
}
