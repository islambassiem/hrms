<?php

namespace App\Http\Resources\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeIdentity;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
class DashboardResource extends JsonResource
{
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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'joiningDate' => $joiningDate->toDateString(),
            'jobTitle' => $this->latestCurrentJobTitle,
            'department' => $this->department?->name,
            'head' => $this->head?->name,
            'annualLeaveBalance' => $this->annualLeaveBalance,
            'contractEndDate' => $contractEndDate?->toDateString(),

            'identifications' => $identifications->map(
                function (EmployeeIdentity $identification): array {
                    /** @var CarbonImmutable|null $expiryDate */
                    $expiryDate = $identification->expiry_date;

                    return [
                        'id' => $identification->identity_type_id,
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
