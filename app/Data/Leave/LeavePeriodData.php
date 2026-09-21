<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\LeavePeriodValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/** Data transfer object for a leave period. */
final class LeavePeriodData extends Data
{
    use LeavePeriodValidationRules;

    /** @param string $name_en @param string $name_ar @param string|null $code @param string $type @param CarbonImmutable $start_date @param CarbonImmutable $end_date @param bool $is_closed */
    public function __construct(public string $name_en, public string $name_ar, public ?string $code, public string $type, public CarbonImmutable $start_date, public CarbonImmutable $end_date, public bool $is_closed = false) {}
}
