<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LeaveRequest
 */
final class DepartmentHeadLeaveRequestResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var CarbonImmutable $startDate */
        $startDate = $this->start_date;

        /** @var CarbonImmutable $endDate */
        $endDate = $this->end_date;

        /** @var CarbonInterface $submittedAt */
        $submittedAt = $this->created_at;

        $employee = $this->relationLoaded('employee')
            ? $this->getRelation('employee')
            : null;
        $leaveType = $this->relationLoaded('leaveType')
            ? $this->getRelation('leaveType')
            : null;

        return [
            'id' => $this->id,
            'employee' => $employee instanceof Employee ? [
                'id' => $employee->id,
                'name' => $employee->name,
                'employeeCode' => $employee->employee_code,
            ] : null,
            'leaveType' => $leaveType instanceof LeaveType ? [
                'id' => $leaveType->id,
                'name' => $leaveType->name,
            ] : null,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'durationDays' => (int) $this->no_of_days,
            'status' => $this->status,
            'submittedDate' => $submittedAt->toDateString(),
            'reason' => $this->reason,
        ];
    }
}
