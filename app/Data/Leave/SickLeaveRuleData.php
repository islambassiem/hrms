<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\SickLeaveRuleValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a sick leave rule. */
final class SickLeaveRuleData extends Data
{
    use SickLeaveRuleValidationRules;

    /** @param int $no_of_days @param float $pay_rate @param CarbonImmutable $effective_from @param CarbonImmutable|null $effective_to */
    public function __construct(public int $no_of_days, public float $pay_rate, public CarbonImmutable $effective_from, public ?CarbonImmutable $effective_to = null) {}
}
