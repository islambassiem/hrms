<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Concerns\Employee\ManagerialRoleValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class ManagerialRoleData extends Data
{
    use ManagerialRoleValidationRules;

    public function __construct(
        public int $employee_id,
        public int $managerial_role_id,
        public CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date = null,
    ) {}
}
