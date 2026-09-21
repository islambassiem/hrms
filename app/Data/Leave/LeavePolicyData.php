<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeavePolicyValidationRules;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave policy. */
final class LeavePolicyData extends Data
{
    use LeavePolicyValidationRules;

    /** @param int $leave_type_id @param string $name_en @param string $name_ar @param float $days_per_year @param bool $is_default @param string $accrual_frequency @param string $period_type @param bool $allow_accumulation @param int $accumulation_periods @param bool $allow_management_carryover @param bool $expire_unused @param bool $encash_on_termination @param float|null $pay_rate */
    public function __construct(public int $leave_type_id, public string $name_en, public string $name_ar, public float $days_per_year, public bool $is_default = false, public string $accrual_frequency = 'monthly', public string $period_type = 'calendar_year', public bool $allow_accumulation = false, public int $accumulation_periods = 1, public bool $allow_management_carryover = false, public bool $expire_unused = true, public bool $encash_on_termination = true, public ?float $pay_rate = null) {}
}
