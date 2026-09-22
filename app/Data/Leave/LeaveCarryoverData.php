<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveCarryoverValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave carryover. */
final class LeaveCarryoverData extends Data
{
    use LeaveCarryoverValidationRules;

    /** @param int $employee_id @param int $leave_type_id @param int $from_period_id @param int $to_period_id @param int|null $source_entitlement_id @param int|null $target_entitlement_id @param float $requested_days @param float $approved_days @param string $status @param string|null $reason @param int|null $requested_by @param int|null $approved_by @param CarbonImmutable|null $requested_at @param CarbonImmutable|null $approved_at @param CarbonImmutable|null $expires_at */
    public function __construct(public int $employee_id, public int $leave_type_id, public int $from_period_id, public int $to_period_id, public ?int $source_entitlement_id = null, public ?int $target_entitlement_id = null, public float $requested_days = 0.0, public float $approved_days = 0.0, public string $status = 'pending', public ?string $reason = null, public ?int $requested_by = null, public ?int $approved_by = null, public ?CarbonImmutable $requested_at = null, public ?CarbonImmutable $approved_at = null, public ?CarbonImmutable $expires_at = null) {}
}
