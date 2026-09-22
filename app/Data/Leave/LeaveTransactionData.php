<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeaveTransactionValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave transaction. */
final class LeaveTransactionData extends Data
{
    use LeaveTransactionValidationRules;

    /** @param int $employee_id @param int $leave_type_id @param int|null $leave_entitlement_id @param int|null $leave_request_id @param string $transaction_type @param float $days @param CarbonImmutable $transaction_date @param CarbonImmutable|null $start_date @param CarbonImmutable|null $end_date @param float|null $balance_after @param float|null $pay_rate @param CarbonImmutable|null $expires_at @param CarbonImmutable|null $payroll_processed_at @param string|null $reference_type @param int|null $reference_id */
    public function __construct(public int $employee_id, public int $leave_type_id, public ?int $leave_entitlement_id, public ?int $leave_request_id, public string $transaction_type, public float $days, public CarbonImmutable $transaction_date, public ?CarbonImmutable $start_date = null, public ?CarbonImmutable $end_date = null, public ?float $balance_after = null, public ?float $pay_rate = null, public ?CarbonImmutable $expires_at = null, public ?CarbonImmutable $payroll_processed_at = null, public ?string $reference_type = null, public ?int $reference_id = null) {}
}
