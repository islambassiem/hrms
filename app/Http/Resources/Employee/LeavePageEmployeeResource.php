<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\JobTitle;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
final class LeavePageEmployeeResource extends JsonResource
{
    public static $wrap = null;

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var EmployeeJobTitle|null $currentJobTitle */
        $currentJobTitle = $this->latestCurrentJobTitle;

        /** @var JobTitle|null $jobTitle */
        $jobTitle = $currentJobTitle?->jobTitle;

        /** @var LeaveBalance|null $annualLeaveBalance */
        $annualLeaveBalance = $this->annualLeaveBalance;

        /** @var CarbonImmutable|null $nextExpiryDate */
        $nextExpiryDate = $annualLeaveBalance?->next_expiry_date;

        return [
            'employee' => [
                'name' => $this->name,
                'employeeCode' => $this->employee_code,
                'department' => $this->department?->name,
                'jobTitle' => $jobTitle?->name,
            ],
            'annualLeave' => $annualLeaveBalance instanceof LeaveBalance ? [
                'availableDays' => (float) $annualLeaveBalance->available_days,
                'accruedDays' => (float) $annualLeaveBalance->accrued_days,
                'usedDays' => (float) $annualLeaveBalance->used_days,
                'pendingDays' => (float) $annualLeaveBalance->pending_days,
                'expiringDays' => (float) $annualLeaveBalance->expiring_days,
                'expiryDate' => $nextExpiryDate?->toDateString(),
            ] : null,
        ];
    }
}
