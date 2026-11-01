<?php

declare(strict_types=1);

namespace App\Data\ShortLeave;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

final class ShortLeaveRequestFiltersData extends Data
{
    public function __construct(
        public int $employeeId,
        public ?int $shortLeaveTypeId = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public ?CarbonImmutable $fromDate = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public ?CarbonImmutable $toDate = null,
    ) {}
}
