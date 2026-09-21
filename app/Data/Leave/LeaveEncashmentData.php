<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveEncashmentValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave encashment. */
final class LeaveEncashmentData extends Data
{
    use LeaveEncashmentValidationRules;

    /** @param int $employee_id @param int $leave_type_id @param int|null $leave_entitlement_id @param float $days @param float $daily_rate @param float $amount @param string $status @param string|null $reason @param int|null $approved_by @param CarbonImmutable|null $approved_at @param CarbonImmutable|null $processed_at @param string|null $payroll_reference */
    public function __construct(public int $employee_id, public int $leave_type_id, public ?int $leave_entitlement_id = null, public float $days = 0.0, public float $daily_rate = 0.0, public float $amount = 0.0, public string $status = 'pending', public ?string $reason = null, public ?int $approved_by = null, public ?CarbonImmutable $approved_at = null, public ?CarbonImmutable $processed_at = null, public ?string $payroll_reference = null) {}
}
