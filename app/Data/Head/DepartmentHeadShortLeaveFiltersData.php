<?php

declare(strict_types=1);

namespace App\Data\Head;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

final class DepartmentHeadShortLeaveFiltersData extends Data
{
    public function __construct(
        public ?int $employeeId = null,
        public ?int $shortLeaveTypeId = null,
        public ?string $status = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public ?CarbonImmutable $fromDate = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public ?CarbonImmutable $toDate = null,
    ) {}
}
