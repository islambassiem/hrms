<?php

namespace App\Http\Resources\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeIdentity;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\JobTitle;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class DashboardResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Collection<int, EmployeeIdentity> $identifications */
        $identifications = $this->identifications;

        /** @var CarbonImmutable $joiningDate */
        $joiningDate = $this->joining_date;

        /** @var CarbonImmutable|null $contractEndDate */
        $contractEndDate = $this->latestContract?->end_date;

        /** @var EmployeeJobTitle|null $currentJobTitle */
        $currentJobTitle = $this->latestCurrentJobTitle;

        /** @var JobTitle|null $jobTitle */
        $jobTitle = $currentJobTitle?->jobTitle;

        /** @var LeaveBalance|null $annualLeaveBalance */
        $annualLeaveBalance = $this->annualLeaveBalance;

        /** @var CarbonImmutable|null $nextExpiryDate */
        $nextExpiryDate = $annualLeaveBalance?->next_expiry_date;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'joiningDate' => $joiningDate->toDateString(),
            'jobTitle' => $jobTitle instanceof JobTitle ? [
                'id' => $jobTitle->id,
                'name' => $jobTitle->name,
            ] : null,
            'department' => $this->department?->name,
            'head' => $this->head?->name,
            'annualLeaveBalance' => $annualLeaveBalance instanceof LeaveBalance ? [
                'availableDays' => (float) $annualLeaveBalance->available_days,
                'accruedDays' => (float) $annualLeaveBalance->accrued_days,
                'usedDays' => (float) $annualLeaveBalance->used_days,
                'pendingDays' => (float) $annualLeaveBalance->pending_days,
                'expiringDays' => (float) $annualLeaveBalance->expiring_days,
                'nextExpiryDate' => $nextExpiryDate?->toDateString(),
            ] : null,
            'contractEndDate' => $contractEndDate?->toDateString(),

            'identifications' => $identifications->map(
                function (EmployeeIdentity $identification): array {
                    /** @var CarbonImmutable|null $expiryDate */
                    $expiryDate = $identification->expiry_date;

                    return [
                        'id' => $identification->id,
                        'type' => $identification->type?->name,
                        'number' => $identification->identity_number,
                        'expiryDate' => $expiryDate?->toDateString(),
                    ];
                }
            )->values()
                ->all(),
        ];
    }
}
