<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Concerns\Leave\EmployeeLeavePolicyValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

/**
 * Data transfer object for an employee leave policy assignment.
 */
final class EmployeeLeavePolicyData extends Data
{
    use EmployeeLeavePolicyValidationRules;

    /**
     * Create an employee leave policy assignment data object.
     *
     * @param  int  $employee_id  The assigned employee identifier.
     * @param  int  $leave_policy_id  The assigned leave policy identifier.
     * @param  CarbonImmutable  $start_date  The date on which the assignment starts.
     * @param  CarbonImmutable|null  $end_date  The optional date on which the assignment ends.
     */
    public function __construct(
        public int $employee_id,
        public int $leave_policy_id,
        public CarbonImmutable $start_date,
        public ?CarbonImmutable $end_date = null,
    ) {}
}
