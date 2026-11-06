<?php

declare(strict_types=1);

namespace App\Data\Head;

use Spatie\LaravelData\Data;

final class DepartmentHeadDashboardData extends Data
{
    public function __construct(
        public int $activeStaffCount,
        public int $maleStaffCount,
        public int $femaleStaffCount,
        public int $pendingRegularLeaveCount,
        public int $pendingShortLeaveCount,
        public int $employeesOnLeaveTodayCount,
    ) {}
}
