<?php

declare(strict_types=1);

namespace App\Data\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/** Data transfer object for a short leave request. */
final class ShortLeaveRequestData extends Data
{
    use ShortLeaveRequestValidationRules;

    public function __construct(
        public int $employee_id,
        public int $short_leave_type_id,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public CarbonImmutable $short_leave_date,
        public string $short_leave_from,
        public string $short_leave_to,
        public string $status = 'pending',
    ) {}
}
